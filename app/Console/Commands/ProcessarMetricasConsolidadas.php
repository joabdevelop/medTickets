<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProcessarMetricasConsolidadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:processar-metricas-consolidadas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa e consolida métricas dos tickets.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        try {
            DB::table('metricas_consolidadas')->truncate();

            $origemSiglaDeptoExpression = "COALESCE(d.sigla_depto, 'S/DEPTO')";

            $query = DB::table('tickets')
                ->leftJoin('profissionals as p', 'p.user_id', '=', 'tickets.user_id_executante')
                ->leftJoin('departamentos as d', 'd.id', '=', 'p.departamento_id')
                ->selectRaw(
                    "
                    COALESCE(DATE(tickets.data_conclusao), DATE(tickets.data_solicitacao)) AS data_metrica,
                    tickets.user_id_executante,
                    tickets.tipo_servico_id,
                    {$origemSiglaDeptoExpression} AS origem_sigla_depto,
                    tickets.status_final,
                    COUNT(tickets.id) AS total_tickets,
                    SUM(CASE WHEN tickets.status_final = 'Concluído' THEN 1 ELSE 0 END) AS tickets_concluidos,
                    SUM(CASE WHEN tickets.data_devolucao IS NOT NULL THEN 1 ELSE 0 END) AS tickets_devolvidos,
                    SUM(CASE WHEN tickets.cumpriu_sla = TRUE THEN 1 ELSE 0 END) AS tickets_sla_ok,
                    SUM(tickets.tempo_execucao) AS tempo_total_execucao_segundos,
                    SUM(CASE WHEN tickets.tempo_execucao > 0 THEN 1 ELSE 0 END) AS total_tickets_com_tempo,
                    NOW() AS created_at,
                    NOW() AS updated_at
                ",
                )
                ->whereIn('tickets.status_final', ['Aberto', 'Em Andamento', 'Pendente', 'Devolvido', 'Concluído'])
                ->groupBy('data_metrica', 'tickets.user_id_executante', 'tickets.tipo_servico_id', DB::raw($origemSiglaDeptoExpression), 'tickets.status_final');

            DB::table('metricas_consolidadas')->insertUsing(['data_metrica', 'user_id_executante', 'tipo_servico_id', 'origem_sigla_depto', 'status_final', 'total_tickets', 'tickets_concluidos', 'tickets_devolvidos', 'tickets_sla_ok', 'tempo_total_execucao_segundos', 'total_tickets_com_tempo', 'created_at', 'updated_at'], $query);

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('❌ Erro ao processar métricas: ' . $e->getMessage());

            // Log registrado para depuração
            logger()->error('Erro no comando de métricas', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}

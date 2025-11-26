<?php

namespace App\Http\Controllers;

use App\Models\MetricasConsolidadas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MetricasConsolidadasController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function processarMetricasConsolidadas(Request $request)
    {
        try {
            DB::table('metricas_consolidadas')->truncate();

            // Expressão completa para a sigla do departamento, para ser usada no SELECT e GROUP BY
            $origemSiglaDeptoExpression = "COALESCE(d.sigla_depto, 'S/DEPTO')";

            $query = DB::table('tickets')
                // 1. JOIN com a tabela de Profissionais
                ->leftJoin('profissionals as p', 'p.user_id', '=', 'tickets.user_id_executante')
                // 2. JOIN com a tabela de Departamentos
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
                    SUM(CASE WHEN tickets.tempo_execucao > 0 THEN 1 ELSE 0 END) AS total_tickets_com_tempo
                    ",
                )
                ->whereIn('tickets.status_final', ['Aberto', 'Em Andamento', 'Pendente', 'Devolvido', 'Concluído'])
                // Agrupamento agora usa a expressão COALESCE completa
                ->groupBy(
                    'data_metrica',
                    'tickets.user_id_executante',
                    'tickets.tipo_servico_id',
                    DB::raw($origemSiglaDeptoExpression), // Usa DB::raw para a expressão complexa
                    'tickets.status_final',
                );

            // Inserção direta na tabela de métricas consolidadas
            DB::table('metricas_consolidadas')->insertUsing(
                [
                    'data_metrica',
                    'user_id_executante',
                    'tipo_servico_id',
                    'origem_sigla_depto', // Nova coluna populada
                    'status_final',
                    'total_tickets',
                    'tickets_concluidos',
                    'tickets_devolvidos',
                    'tickets_sla_ok',
                    'tempo_total_execucao_segundos',
                    'total_tickets_com_tempo',
                ],
                $query,
            );

            return redirect()
        ->route('dashboard.operacional')   // <--- qualquer rota final
        ->with('success', 'Métricas consolidadas com sucesso!');
            
        } catch (Throwable $th) {
            return redirect()
                ->route('dashboard.operacional')
                ->with('error', 'Erro ao processar métricas: ' . $th->getMessage());
        }
    }
}

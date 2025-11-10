<?php

namespace App\Http\Controllers;

use App\Models\MetricasConsolidadas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MetricasConsolidadasController extends Controller
{
    public function processarMetricasConsolidadas(Request $request)
    {
        try {
            // Limpa a tabela de métricas consolidadas
            DB::table('metricas_consolidadas')->truncate();
 
            // 1. Define a consulta de agregação dos tickets
            $query = DB::table('tickets')
                ->selectRaw(
                    "
                        DATE(data_conclusao) AS data_metrica,
                        user_id_executante,
                        tipo_servico_id,
                        origem_sigla_depto,
                        COUNT(id) AS total_tickets,
                        SUM(CASE WHEN status_final = 'Concluído' THEN 1 ELSE 0 END) AS tickets_concluidos,
                        SUM(CASE WHEN cumpriu_sla = TRUE THEN 1 ELSE 0 END) AS tickets_sla_ok,
                        SUM(tempo_execucao) AS tempo_total_execucao_segundos,
                        SUM(CASE WHEN tempo_execucao > 0 THEN 1 ELSE 0 END) AS total_tickets_com_tempo
                    "
                )
                ->whereNotNull('data_conclusao')
                ->whereIn('status_final', ['Concluído', 'Devolvido', 'Pendente'])
                ->whereNotNull('user_id_executante')
                ->groupBy('data_metrica', 'user_id_executante', 'tipo_servico_id', 'origem_sigla_depto');
 
            // 2. Executa um 'INSERT ... SELECT ...' para inserir todos os dados de uma vez
            DB::table('metricas_consolidadas')->insertUsing(
                ['data_metrica', 'user_id_executante', 'tipo_servico_id', 'origem_sigla_depto', 'total_tickets', 'tickets_concluidos', 'tickets_sla_ok', 'tempo_total_execucao_segundos', 'total_tickets_com_tempo'],
                $query
            );
 
            // Retorna com sucesso APÓS a conclusão bem-sucedida
            return redirect()->back()->with('success', 'Métricas consolidadas foram processadas com sucesso!');
 
        } catch (\Throwable $th) {
            // Em caso de erro, redireciona para trás com a mensagem de erro
            // Opcional: Logar o erro para depuração
            // Log::error('Falha ao processar métricas: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Erro ao processar métricas: ' . $th->getMessage());
        }
    }
}

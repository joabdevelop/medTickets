<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MetricasConsolidadas;
use App\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard de SLA com métricas consolidadas.
     */
    public function indexSla(Request $request)
    {
        // Lógica de filtro de data (padrão: 30 dias)
        $periodo = $request->input('periodo', 30);
        $dataInicio = Carbon::today()->subDays($periodo - 1);

        // 1. KPIs Principais (Cards)
        $kpis = MetricasConsolidadas::query()
            ->where('data_metrica', '>=', $dataInicio)
            ->selectRaw(
                '
                SUM(tempo_total_execucao_segundos) as total_segundos,
                SUM(total_tickets_com_tempo) as total_com_tempo,
                SUM(tickets_sla_ok) as total_sla_ok,
                SUM(total_tickets) as total_geral
            ',
            )
            ->first();

        // Calcula o tempo médio de resolução e formata
        $mediaSegundos = $kpis->total_com_tempo > 0 ? $kpis->total_segundos / $kpis->total_com_tempo : 0;
        $tempoMedioResolucao = gmdate('H\h i\m', (int) $mediaSegundos);

        // Calcula o percentual de SLA cumprido
        $percentualSlaResolucao = $kpis->total_geral > 0 ? round(($kpis->total_sla_ok / $kpis->total_geral) * 100) : 0;

        // Para o SLA de primeira resposta, usaremos o mesmo dado por enquanto.
        $percentualSlaResposta = $percentualSlaResolucao;

        // 2. Top 10 Tickets com Maior Tempo de Resolução
        $topTicketsLentos = Ticket::with('user_executante')->whereNotNull('tempo_execucao')->orderByDesc('tempo_execucao')->limit(10)->get();

        // 3. SLA de Resolução por Agente
        $slaPorAgente = MetricasConsolidadas::with('user.user') // Carrega o profissional e o usuário
            ->where('data_metrica', '>=', $dataInicio)
            ->whereNotNull('user_id_executante')
            ->groupBy('user_id_executante')
            ->selectRaw(
                '
                user_id_executante,
                (SUM(tickets_sla_ok) / SUM(total_tickets)) * 100 as percentual_sla
            ',
            )
            ->orderByDesc('percentual_sla')
            ->get();

        // Prepara os dados para o gráfico de agentes
        $agentesLabels = $slaPorAgente->map(fn($item) => $item->user->user->name ?? 'Desconhecido');
        $agentesValores = $slaPorAgente->map(fn($item) => round($item->percentual_sla));

        // 4. Envia os dados para a view
        return view('dashboard.sla', [
            'tempoMedioResolucao' => $tempoMedioResolucao,
            'percentualSlaResolucao' => $percentualSlaResolucao,
            'percentualSlaResposta' => $percentualSlaResposta,
            'topTicketsLentos' => $topTicketsLentos,
            'agentesLabels' => $agentesLabels,
            'agentesValores' => $agentesValores,
            'periodo' => $periodo,
        ]);
    }

    /**
     * Placeholder para outros dashboards.
     */
    public function indexOperacional()
    {
        // Lógica para o dashboard operacional
        return view('dashboard.operacional'); // Supondo que a view exista
    }

    public function indexEquipe()
    {
        // Lógica para o dashboard de equipe
        return view('dashboard.desempenhoEquipe'); // Supondo que a view exista
    }
}

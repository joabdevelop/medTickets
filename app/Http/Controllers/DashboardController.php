<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MetricasConsolidadas;
use App\Models\Ticket;
use App\Models\Departamento;
use App\Models\Profissional;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard de SLA com métricas consolidadas.
     */
    public function indexSla(Request $request)
    {
        if ($request->input('inicio') !== null || $request->input('fim') !== null) {
            //Validação de data
            $validated = $request->validate(
                [
                    'inicio' => 'nullable|date|before_or_equal:fim',
                    'fim' => 'nullable|date',
                ],
                [
                    'inicio' => 'Data inicial deve ser menor ou igual à data final.',
                    'fim' => 'Data final deve ser maior que a data inicial.',
                ],
            );

            if (!$validated) {
                return redirect()->back()->withInput()->with('error', 'Data inicial deve ser anterior à data final.');
            }
        }

        // Lógica de filtro de data (padrão: 30 dias)
        $periodo = $request->input('periodo', 30);

        $dataInicio = $request->input('inicio', now()->subDays($periodo)->startOfDay()->toDateString());
        $dataFim = $request->input('fim', now()->toDateString());

        // 1. KPIs Principais (Cards)
        $kpis = MetricasConsolidadas::query()
            ->where('data_metrica', '>=', $dataInicio)
            ->where('data_metrica', '<=', $dataFim)
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
        $topTicketsLentos = Ticket::with('user_executante', 'tipo_servico')->whereNotNull('tempo_execucao')->orderByDesc('tempo_execucao')->limit(10)->get();

        // 3. SLA de Resolução por Agente
        $slaPorAgente = MetricasConsolidadas::with('user.user') // Carrega o profissional e o usuário
            ->where('data_metrica', '>=', $dataInicio)
            ->where('data_metrica', '<=', $dataFim)
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
        $viewData = [
            'tempoMedioResolucao' => $tempoMedioResolucao,
            'percentualSlaResolucao' => $percentualSlaResolucao,
            'percentualSlaResposta' => $percentualSlaResposta,
            'topTicketsLentos' => $topTicketsLentos,
            'agentesLabels' => $agentesLabels,
            'agentesValores' => $agentesValores,
            'periodo' => $periodo,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ];

        return view('dashboard.sla', $viewData);
    }

    /**
     * Placeholder para outros dashboards.
     */
    public function indexOperacional(Request $request)
    {
        $deptos = Departamento::All();

        // 1. Capturar e definir o período
        $dataInicio = $request->input('inicio', now()->subMonths(3)->startOfMonth()->toDateString());
        $dataFim = $request->input('fim', now()->toDateString());

        // 2. Captura o filtro de Departamento, usando 'TODOS' como padrão
        $origemDepto = $request->input('origem_sigla_depto', 'TODOS');

        // Funções auxiliares para evitar repetição no join do agente
        $joinProfissional = function ($query) {
            // OBS: Verifique se 'p.id' ou 'p.user_id' é a chave correta para metricas_consolidadas.user_id_executante
            $query->leftJoin('profissionals as p', 'p.id', '=', 'metricas_consolidadas.user_id_executante');
        };
        $selectNomeAgente = DB::raw('COALESCE(p.nome, "Sem Agente") as nome_agente');

        // 3. NOVO: Função para aplicar o filtro de departamento (Closure)
        $applyDeptoFilter = function ($query) use ($origemDepto) {
            // Aplica o filtro SOMENTE se o valor não for 'TODOS'
            if ($origemDepto !== 'TODOS') {
                $query->where('origem_sigla_depto', '=', $origemDepto);
            }
        };

        // Captura a data da última geração de métricas
        $ultimaGeracao = DB::table('metricas_consolidadas')->max('created_at');

        // --- 1️⃣ Utilização / Ocupação do Agente ---
        $ocupacao = DB::table('metricas_consolidadas as mc')
            ->leftJoin('profissionals as p', 'p.id', '=', 'mc.user_id_executante')
            ->select(
                'mc.user_id_executante',
                $selectNomeAgente,
                // Tempo médio de execução em segundos.
                DB::raw('ROUND(SUM(mc.tempo_total_execucao_segundos) / NULLIF(SUM(mc.total_tickets_com_tempo),0), 0) AS tempo_medio_segundos'),
            )
            ->whereBetween('mc.data_metrica', [$dataInicio, $dataFim])
            ->whereNotNull('mc.user_id_executante') // Agrupar por agente
            ->tap($applyDeptoFilter) // <--- Aplicação do filtro
            ->groupBy('mc.user_id_executante', 'p.nome')
            ->orderBy('tempo_medio_segundos', 'desc')
            ->get();

        // --- 2️⃣ Taxa de Absenteísmo (Dias Trabalhados) ---
        $diasTrabalhados = DB::table('metricas_consolidadas')
            ->select(
                'metricas_consolidadas.user_id_executante',
                DB::raw('COUNT(DISTINCT data_metrica) as dias_trabalhados'),
                // Adicione o nome do agente à sua consulta:
                DB::raw('COALESCE(p.nome, "N/A - Sem Executante") as nome_agente'),
            )
            // O JOIN é essencial para buscar o nome (Ajuste o join se o campo for p.id)
            ->leftJoin('profissionals as p', 'p.user_id', '=', 'metricas_consolidadas.user_id_executante')
            ->whereBetween('data_metrica', [$dataInicio, $dataFim])
            ->tap($applyDeptoFilter) // <--- Aplicação do filtro
            ->groupBy('metricas_consolidadas.user_id_executante', 'nome_agente')
            ->get();

        // --- 3️⃣ Nível de Serviço (SLA) ---
        // Calculado por Mês, não precisa do join de agente
        $sla = DB::table('metricas_consolidadas')
            ->select(
                // Usa DATE_FORMAT para obter um rótulo de mês/ano mais amigável
                DB::raw('DATE_FORMAT(data_metrica, "%Y-%m") AS mes_ano'),
                DB::raw('ROUND(SUM(tickets_sla_ok) / NULLIF(SUM(total_tickets),0) * 100, 2) AS sla_percentual'),
            )
            ->whereBetween('data_metrica', [$dataInicio, $dataFim])
            ->tap($applyDeptoFilter) // <--- Aplicação do filtro
            // Agrupa por mês/ano para evitar problemas com anos diferentes
            ->groupBy(DB::raw('DATE_FORMAT(data_metrica, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(data_metrica, "%Y-%m")'))
            ->get();

        // --- 4️⃣ Número de Interações por Agente ---
        $interacoes = DB::table('metricas_consolidadas')
            ->tap($joinProfissional) // Adiciona o join
            ->select('user_id_executante', $selectNomeAgente, DB::raw('SUM(total_tickets) AS total_interacoes'))
            ->whereBetween('data_metrica', [$dataInicio, $dataFim])
            ->whereNotNull('user_id_executante')
            ->tap($applyDeptoFilter) // <--- Aplicação do filtro
            ->groupBy('user_id_executante', 'p.nome')
            ->orderByDesc('total_interacoes')
            ->get();

        // --- 5️⃣ Ranking de Produtividade ---
        // Adiciona o join para obter o nome do agente
        $ranking = DB::table('metricas_consolidadas')
            ->tap($joinProfissional) // Adiciona o join
            ->select(
                'user_id_executante',
                $selectNomeAgente,
                DB::raw('SUM(tickets_concluidos) AS total_concluidos'),
                // CSAT aqui é o SLA. Seria mais correto usar uma métrica de Satisfação (CSAT) se disponível.
                DB::raw('ROUND(SUM(tickets_sla_ok) / NULLIF(SUM(total_tickets),0) * 100, 2) AS sla_percentual'),
                DB::raw('ROUND(SUM(tempo_total_execucao_segundos) / NULLIF(SUM(total_tickets_com_tempo),0), 0) AS tempo_medio_seg'),
            )
            ->whereBetween('data_metrica', [$dataInicio, $dataFim])
            ->whereNotNull('user_id_executante')
            ->tap($applyDeptoFilter) // <--- Aplicação do filtro
            ->groupBy('user_id_executante', 'p.nome')
            ->orderByDesc('total_concluidos')
            ->limit(10)
            ->get();

        $viewData = [
            'ocupacao' => $ocupacao,
            'absenteismo',
            'sla' => $sla,
            'interacoes' => $interacoes,
            'ranking' => $ranking,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'diasTrabalhados' => $diasTrabalhados,
            'origemDepto' => $origemDepto, // Retorna o valor do filtro
            'deptos' => $deptos, // Lista de departamentos
            'ultimaGeracao' => $ultimaGeracao,
        ];

        return view('dashboard.operacional', $viewData);
    }

    public function indexEquipe(Request $request)
    {
        if ($request->input('inicio') !== null || $request->input('fim') !== null) {
            //Validação de data
            $validated = $request->validate(
                [
                    'inicio' => 'nullable|date|before_or_equal:fim',
                    'fim' => 'nullable|date',
                ],
                [
                    'inicio' => 'Data inicial deve ser menor ou igual à data final.',
                    'fim' => 'Data final deve ser maior que a data inicial.',
                ],
            );

            if (!$validated) {
                return redirect()->back()->withInput()->with('error', 'Data inicial deve ser anterior à data final.');
            }
        }

        // Lógica de filtro de data (padrão: 30 dias)
        $periodo = $request->input('periodo', 30);

        $dataInicio = $request->input('inicio', now()->subDays($periodo)->startOfDay()->toDateString());
        $dataFim = $request->input('fim', now()->toDateString());

        $dados = DB::table('metricas_consolidadas')
            ->select('origem_sigla_depto', DB::raw('SUM(total_tickets) as total'), DB::raw('SUM(tickets_concluidos) as concluidos'), DB::raw('SUM(tickets_devolvidos) as devolvidos'), DB::raw('SUM(tickets_sla_ok) as sla_ok'), DB::raw('SUM(tempo_total_execucao_segundos) as tempo_total'), DB::raw('SUM(total_tickets_com_tempo) as tickets_tempo'))
            ->whereBetween('data_metrica', [$dataInicio, $dataFim])
            ->groupBy('origem_sigla_depto')
            ->get();
        // Lógica para o dashboard de equipe
        $viewData = compact('dados', 'dataInicio', 'dataFim');

        return view('dashboard.desempenhoEquipe', $viewData); // Supondo que a view exista
    }
}

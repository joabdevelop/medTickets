<div class="d-flex min-vh-100 w-100">

    <main class="flex-grow-1 overflow-auto p-4 p-md-5">
        <div class="container-fluid mx-auto">
            {{-- ... Conteúdo da div de Heading e Filtros ... --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
                <div class="d-flex flex-column gap-2">
                    <h1 class="text-dark-custom display-6 fw-bold mb-0">Dashboard - Operacional</h1>
                    <p class="text-subtitle lead mb-0 fs-6">Acompanhe as métricas de performance da equipe de
                        atendimento.</p>
                    @if ($ultimaGeracao)
                        <p>Última atualização: {{ \Carbon\Carbon::parse($ultimaGeracao)->format('d/m/Y H:i:s') }}
                        </p>
                    @else
                        <p>Métricas ainda não foram geradas.</p>
                    @endif
                </div>
                <form action="{{ route('dashboard.operacional') }}" method="GET" class="d-flex flex-wrap gap-2">
                    <input type="date" name="inicio" value="{{ $dataInicio }}">
                    <input type="date" name="fim" value="{{ $dataFim }}">
                    <button type="submit" class="btn btn-primary d-flex align-items-center">Aplicar Filtro</button>
                </form>
                <form id="origem_sigla_depto_form" class="d-flex flex-wrap gap-2">
                    <!-- Adicione action e method aqui, se ainda não estiverem na tag form -->
                    <div class="d-flex flex-column gap-2">
                        <select name="origem_sigla_depto" id="origem_sigla_depto_id">
                            <!-- Verifica se a variável $origemDepto (retornada do Controller) é 'TODOS' -->
                            <option value="TODOS" @if ($origemDepto === 'TODOS') selected @endif>Todos</option>

                            @foreach ($deptos as $depto)
                                <option value="{{ $depto->sigla_depto }}"
                                    @if (isset($origemDepto) && $origemDepto === $depto->sigla_depto) selected @endif>
                                    {{ $depto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="card-title text-dark-custom fw-medium mb-1">Tempo Médio de Execução (TME) por
                                Agente</p>
                            @php
                                $totalSegundosOcupacao = $ocupacao->sum('tempo_medio_segundos');
                                $mediaSegundosOcupacao =
                                    $ocupacao->count() > 0 ? $totalSegundosOcupacao / $ocupacao->count() : 0;
                            @endphp
                            <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2" id="tme-geral">
                                {{ gmdate('H\\h i\\m', $mediaSegundosOcupacao) }}
                            </h2>
                            <p class="text-subtitle small mb-4">Média Geral do Período</p>
                            <div style="height: 220px;">
                                <canvas id="chartUtilizacao"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="card-title text-dark-custom fw-medium mb-1">Taxa de Absenteísmo (Ausência de
                                Atividade) por Agente</p>
                            @php
                                $registroTotalDias = $diasTrabalhados->firstWhere('user_id_executante', null);
                                $totalDiasPeriodo = $registroTotalDias ? $registroTotalDias->dias_trabalhados : 0;

                                $diasAgentes = $diasTrabalhados->filter(function ($item) {
                                    return $item->user_id_executante !== null;
                                });

                                $totalDiasTrabalhadosAgentes = $diasAgentes->sum('dias_trabalhados');
                                $numAgentes = $diasAgentes->count();

                                if ($totalDiasPeriodo > 0 && $numAgentes > 0) {
                                    $mediaDiasTrabalhados = $totalDiasTrabalhadosAgentes / $numAgentes;
                                    $diasAusentesMedios = $totalDiasPeriodo - $mediaDiasTrabalhados;
                                    $taxaGeralAbsenteismo = ($diasAusentesMedios / $totalDiasPeriodo) * 100;
                                } else {
                                    $taxaGeralAbsenteismo = 0;
                                }
                            @endphp
                            <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">
                                {{ number_format($taxaGeralAbsenteismo, 2) }}%
                            </h2>
                            <p class="text-subtitle small mb-4">Média Geral do Período</p>
                            <div style="height: 220px;">
                                <canvas id="chartAbsenteismo"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="card-title text-dark-custom fw-medium mb-1">Nível de Serviço (SLA) Mensal</p>
                            @php
                                $slaAtual = $sla->last() ? $sla->last()->sla_percentual : 0;
                            @endphp
                            <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">
                                {{ number_format($slaAtual, 2) }}%
                            </h2>
                            <p class="text-subtitle small mb-4">Último Mês/Período</p>
                            <div style="height: 220px;">
                                <canvas id="chartSLA"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="card-title text-dark-custom fw-medium mb-1">Número de Atividades por Agente
                            </p>
                            @php
                                $totalInteracoes = $interacoes->sum('total_interacoes');
                            @endphp
                            <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">
                                {{ number_format($totalInteracoes, 0, ',', '.') }}
                            </h2>
                            <p class="text-subtitle small mb-4">Total no Período</p>
                            <div style="height: 220px;">
                                <canvas id="chartInteracoes"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 d-flex align-items-center justify-content-between">
                <h2 class="text-dark-custom fs-4 fw-bold mb-0">Ranking de Produtividade dos Agentes (Top 10)</h2>
                <button class="btn btn-light border d-flex align-items-center text-dark-custom">
                    <span class="material-symbols-outlined me-2 fs-6">download</span>
                    Exportar
                </button>
            </div>

            <div class="card shadow-sm mt-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Rank
                                </th>
                                <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">
                                    Agente</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">
                                    Tickets Concluídos</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">
                                    SLA/Qualidade
                                </th>
                                <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Tempo
                                    Médio Atendimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ranking as $key => $item)
                                @php
                                    $badgeClass = 'bg-danger';
                                    if ($item->sla_percentual >= 95) {
                                        $badgeClass = 'bg-success';
                                    } elseif ($item->sla_percentual >= 90) {
                                        $badgeClass = 'bg-warning text-dark';
                                    }

                                    $tempoFormatado = gmdate('i\\m s\\s', $item->tempo_medio_seg);
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 fw-medium text-dark">{{ $key + 1 }}</td>
                                    <td class="px-4 py-3 fw-medium text-dark">{{ $item->nome_agente }}</td>
                                    <td class="px-4 py-3">{{ $item->total_concluidos }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge rounded-pill {{ $badgeClass }} py-1">{{ number_format($item->sla_percentual, 2) }}%</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $tempoFormatado }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Nenhuma métrica de ranking
                                        encontrada para o período.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>


</div>

<script>
    function formatSecondsToHHMM(totalSeconds) {
        totalSeconds = Math.round(totalSeconds);

        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);

        const paddedHours = String(hours).padStart(2, '0') + 'h';
        const paddedMinutes = String(minutes).padStart(2, '0') + 'm';

        if (hours > 0) {
            return `${paddedHours}:${paddedMinutes}`;
        } else {
            return `${paddedMinutes}m`;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        document.addEventListener('change', function(event) {
            if (event.target.id === 'origem_sigla_depto_id') {
                const form = document.getElementById('origem_sigla_depto_form');

                if (form) {
                    form.submit();
                } else {
                    console.error("Formulário 'origem_sigla_depto_form' não encontrado.");
                }
            }
        });

        const primaryColor = '#007bff';
        const primaryLight = 'rgba(0, 123, 255, 0.3)';

        const diasTrabalhadosData = @json($diasTrabalhados);
        const ocupacaoData = @json($ocupacao);
        const slaData = @json($sla);
        const interacoesData = @json($interacoes);

        new Chart(document.getElementById('chartUtilizacao'), {
            type: 'bar',
            data: {
                labels: ocupacaoData.map(o => o.nome_agente),
                datasets: [{
                    label: 'TME (hh:mm)',
                    data: ocupacaoData.map(o => o.tempo_medio_segundos),
                    backgroundColor: '#007bff',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatSecondsToHHMM(value);
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: function(context) { return context[0].label; },
                            label: function(context) { return 'TME: ' + formatSecondsToHHMM(context.raw); }
                        }
                    }
                }
            }
        });

        const totalDiasPeriodo = diasTrabalhadosData.find(d => d.user_id_executante === null)
            ?.dias_trabalhados || 0;

        const absenteismoAusenciaData = diasTrabalhadosData
            .filter(d => d.user_id_executante !== null)
            .map(d => {
                const diasAusentes = totalDiasPeriodo - d.dias_trabalhados;
                const taxaAbsenteismo = totalDiasPeriodo > 0 ? (diasAusentes / totalDiasPeriodo) * 100 : 0;

                return {
                    nome_agente: d.nome_agente,
                    taxa: taxaAbsenteismo.toFixed(2),
                    dias_ausentes: diasAusentes
                };
            });

        new Chart(document.getElementById('chartAbsenteismo'), {
            type: 'bar',
            data: {
                labels: absenteismoAusenciaData.map(d => d.nome_agente),
                datasets: [{
                    label: 'Absenteísmo (%)',
                    data: absenteismoAusenciaData.map(d => d.taxa),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { callback: function(value) { return value + '%'; } } },
                    x: { grid: { display: false } }
                },
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(context) { const dataItem = absenteismoAusenciaData[context.dataIndex]; return `Ausência: ${dataItem.taxa}% (${dataItem.dias_ausentes} dias)`; } } } }
            }
        });

        new Chart(document.getElementById('chartSLA'), {
            type: 'line',
            data: {
                labels: slaData.map(s => s.mes_ano),
                datasets: [{
                    label: 'SLA (%)',
                    data: slaData.map(s => s.sla_percentual),
                    borderColor: primaryColor,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: primaryLight,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, max: 100, ticks: { callback: function(value) { return value + "%"; } } } },
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(context) { return context.formattedValue + '%'; } } } }
            }
        });

        new Chart(document.getElementById('chartInteracoes'), {
            type: 'bar',
            data: {
                labels: interacoesData.map(i => i.nome_agente),
                datasets: [{
                    label: 'Total de Atividades',
                    data: interacoesData.map(i => i.total_interacoes),
                    backgroundColor: primaryColor,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true }, x: { grid: { display: false } } },
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(context) { return context.formattedValue + ' Atividades'; } } } }
            }
        });
    });
</script>

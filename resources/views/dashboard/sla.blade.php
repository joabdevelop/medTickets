<x-app-layout title="SLA">

    <!-- Conteúdo Principal -->
    <div class="container-lg">
        <!-- Cabeçalho da Página e Filtros -->
        <header class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">
            <div>
                <h1 class="h2 fw-bold mb-1">Dashboard - SLA </h1>
                <p class="text-muted mb-0">Acompanhe os principais indicadores de desempenho da equipe.</p>
            </div>
            <form method="GET" action="{{ route('dashboard.sla') }}" class="d-flex align-items-center gap-2"
                role="group">
                <div class="btn-group btn-group-sm shadow-sm" role="group">
                    <button type="submit" name="periodo" value="1"
                        class="btn @if ($periodo == 1) btn-primary @else btn-outline-secondary @endif">Hoje</button>
                    <button type="submit" name="periodo" value="7"
                        class="btn @if ($periodo == 7) btn-primary @else btn-outline-secondary @endif">7 dias</button>
                    <button type="submit" name="periodo" value="30"
                        class="btn @if ($periodo == 30) btn-primary @else btn-outline-secondary @endif">30 dias</button>
                </div>
                {{-- <button class="btn btn-light bg-body btn-sm shadow-sm border d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-month"></i> Período <i class="bi bi-chevron-down small"></i>
                </button>
                <button class="btn btn-light bg-body btn-sm shadow-sm border d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-month"></i> Departamento <i class="bi bi-chevron-down small"></i>
                </button> --}}
            </form>
        </header>

        <!-- Grid de Stats (KPIs e Donuts) -->
        <div class="row row-cols-1 row-cols-lg-3 g-4">
            <!-- KPI Card -->
            <div class="col">
                <div class="card h-100 shadow-sm rounded-xl">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start text-muted">
                            <h3 class="h6 text-muted fw-medium">Tempo de Resolução Médio</h3>
                            <i class="bi bi-timer fs-5"></i>
                        </div>
                        <div>
                            <p class="h1 fw-bold my-2">{{ $tempoMedioResolucao }}</p>
                            {{-- <p class="text-positive small fw-medium d-flex align-items-center gap-1 mb-0">
                                <i class="bi bi-arrow-up-short"></i>
                                <span>-5.2% vs. mês anterior</span>
                            </p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Donut Chart Card -->
            <div class="col">
                <div class="card h-100 shadow-sm rounded-xl">
                    <div class="card-body p-4 text-center">
                        <h3 class="h6 text-muted fw-medium">SLA de Primeira Resposta</h3>
                        <div class="chart-container mx-auto" style="max-height: 160px; position: relative;">
                            <canvas id="donutSlaResposta"></canvas>
                            <div class="chart-donut-label"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <h3 class="h2 fw-bold mb-0">{{ $percentualSlaResposta }}%</h3>
                                <span class="small text-muted">Cumprido</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Donut Chart Card -->
            <div class="col">
                <div class="card h-100 shadow-sm rounded-xl">
                    <div class="card-body p-4 text-center">
                        <h3 class="h6 text-muted fw-medium">SLA Cumprido (Resolução)</h3>
                        <div class="chart-container mx-auto" style="max-height: 160px; position: relative;">
                            <canvas id="donutSlaResolucao"></canvas>
                            <div class="chart-donut-label"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <h3 class="h2 fw-bold mb-0">{{ $percentualSlaResolucao }}%</h3>
                                <span class="small text-muted">Cumprido</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de Gráficos (Linha e Barras Horizontais) -->
        <div class="row g-4 mt-4">
            <!-- Tabela de Dados (Top 10 Tickets - Ocupa 8/12 da largura em telas grandes) -->
            <div class="col-xl-8">
                <!-- Removido o 'mt-4' desnecessário, pois o espaçamento é gerenciado pela 'row g-4' -->
                <div class="card shadow-sm rounded-xl">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title h5 fw-semibold mb-4">Top 10 Tickets com Maior Tempo de Resolução</h3>
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle caption-top">
                                <thead >
                                    <tr>
                                        <th scope="col" class="py-3 px-3">Ticket</th>
                                        <th scope="col" class="py-3 px-3">Descrição</th>
                                        <th scope="col" class="py-3 px-3">Agente</th>
                                        <th scope="col" class="py-3 px-3">Status</th>
                                        <th scope="col" class="py-3 px-3">Tempo de Resolução</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        dd($topTicketsLentos)
                                    @endphp
                                    @forelse ($topTicketsLentos as $ticket)

                                        @php
                                            $statusEnum = \App\Enums\StatusTickets::tryFrom($ticket->status_final);
                                        @endphp
                                        <tr>
                                            <td class="px-3 fw-medium text-primary">{{ $ticket->numero_ticket }}</td>
                                            <td class="px-3">{{ Str::limit($ticket->descricao_servico, 40) }}</td>
                                            <td class="px-3">{{ $ticket->user_executante->nome ?? 'N/A' }}</td>
                                            <td class="px-3">
                                                @if ($statusEnum)
                                                    <span class="badge rounded-pill fw-medium {{ $statusEnum->getBootstrapClass(true) }}">
                                                        {{ $statusEnum->value }}
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill fw-medium bg-secondary-subtle text-secondary-emphasis">
                                                        {{ $ticket->status_final }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 fw-medium text-negative">{{ gmdate('H\h i\m', $ticket->tempo_execucao * 60) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Nenhum ticket encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Horizontal Bar Chart (SLA de Resolução - Ocupa 4/12 da largura em telas grandes) -->
            <div class="col-xl-4 h-100">
                <div class="card shadow-sm rounded-xl h-100 ">
                    <div class="card-body h-100">
                        <h3 class="card-title h5 fw-semibold mb-1">SLA de Resolução por Agente</h3>
                        <p class="card-subtitle text-muted small mb-4">Neste mês</p>
                        <!-- Adicionado overflow-y: auto para rolagem vertical se o gráfico for maior que 320px -->
                        <div style="height: 320px; overflow-y: auto;">
                            <canvas  id="barChartAgentes"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    @push('scripts')
        <!-- 6. Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

        <!-- 7. Script dos Gráficos -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // Dados de exemplo (substitua pelos seus dados reais)
                const donutSlaRespostaData = {
                    value: {{ $percentualSlaResposta }},
                    color: '#007bff' // primary
                };
                const donutSlaResolucaoData = {
                    value: {{ $percentualSlaResolucao }},
                    color: '#28a745' // positive
                };

                const barDataAgentes = {
                    labels: @json($agentesLabels),
                    valores: @json($agentesValores)
                };

                // Cores base
                const corPositiva = '#28a745';
                const corNegativa = '#dc3545';
                const corAlerta = '#ffc107';
                const corPrimaria = '#007bff';
                const corBorda = '#e2e8f0';
                const corTextoSecundario = '#6c757d';

                // --- Função Auxiliar para cor da barra ---
                function getBarColor(value) {
                    if (value >= 90) return corPositiva;
                    if (value >= 80) return corAlerta;
                    return corNegativa;
                }

                // --- Gráfico Donut 1: SLA Primeira Resposta ---
                const ctxDonut1 = document.getElementById('donutSlaResposta');
                if (ctxDonut1) {
                    new Chart(ctxDonut1, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [donutSlaRespostaData.value, 100 - donutSlaRespostaData.value],
                                backgroundColor: [donutSlaRespostaData.color, corBorda],
                                borderColor: 'transparent'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '80%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false
                                }
                            }
                        }
                    });
                }

                // --- Gráfico Donut 2: SLA Resolução ---
                const ctxDonut2 = document.getElementById('donutSlaResolucao');
                if (ctxDonut2) {
                    new Chart(ctxDonut2, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [donutSlaResolucaoData.value, 100 - donutSlaResolucaoData.value],
                                backgroundColor: [donutSlaResolucaoData.color, corBorda],
                                borderColor: 'transparent'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '80%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false
                                }
                            }
                        }
                    });
                }


                // --- Gráfico de Barras Horizontal: Agentes ---
                const ctxBar = document.getElementById('barChartAgentes');
                if (ctxBar) {
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: barDataAgentes.labels,
                            datasets: [{
                                label: 'SLA de Resolução',
                                data: barDataAgentes.valores,
                                backgroundColor: barDataAgentes.valores.map(v => getBarColor(v)),
                                borderRadius: 4
                            }]
                        },
                        options: {
                            indexAxis: 'y', // <-- Torna o gráfico horizontal
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: (context) => context.raw + '%'
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 100,
                                    grid: {
                                        color: corBorda
                                    },
                                    ticks: {
                                        color: corTextoSecundario,
                                        callback: (value) => value + '%'
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: corTextoSecundario
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>

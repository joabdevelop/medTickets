<x-app-layout title="SLA">

    <!-- Conteúdo Principal -->
    <div class="container-lg">
        <!-- Cabeçalho da Página e Filtros -->
        <header class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">
            <div>
                <h1 class="h2 fw-bold mb-1">Dashboard de SLA Por Departamento</h1>
                <p class="text-muted mb-0">Acompanhe os principais indicadores de desempenho da equipe.</p>
            </div>
            <div class="d-flex align-items-center gap-2" role="group">
                <div class="btn-group btn-group-sm shadow-sm" role="group">
                    <input type="radio" class="btn-check" name="timefilter" id="filter_today" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="filter_today">Hoje</label>

                    <input type="radio" class="btn-check" name="timefilter" id="filter_7days" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="filter_7days">7 dias</label>

                    <input type="radio" class="btn-check" name="timefilter" id="filter_30days" autocomplete="off"
                        checked>
                    <label class="btn btn-primary" for="filter_30days">30 dias</label>
                </div>
                <button class="btn btn-light bg-body btn-sm shadow-sm border d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-month"></i> Período <i class="bi bi-chevron-down small"></i>
                </button>
            </div>
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
                            <p class="h1 fw-bold my-2">8h 32m</p>
                            <p class="text-positive small fw-medium d-flex align-items-center gap-1 mb-0">
                                <i class="bi bi-arrow-up-short"></i>
                                <span>-5.2% vs. mês anterior</span>
                            </p>
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
                                <h3 class="h2 fw-bold mb-0">92%</h3>
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
                                <h3 class="h2 fw-bold mb-0">85%</h3>
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
                                        <th scope="col" class="py-3 px-3">Ticket ID</th>
                                        <th scope="col" class="py-3 px-3">Assunto</th>
                                        <th scope="col" class="py-3 px-3">Agente</th>
                                        <th scope="col" class="py-3 px-3">Status</th>
                                        <th scope="col" class="py-3 px-3">Tempo de Resolução</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-3 fw-medium text-primary">#78321</td>
                                        <td class="px-3">Problema com faturamento da assinatura</td>
                                        <td class="px-3">Lucas</td>
                                        <td class="px-3"><span
                                                class="badge rounded-pill fw-medium bg-warning-subtle">Em
                                                Aberto</span></td>
                                        <td class="px-3 fw-medium text-negative">96h 15m</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 fw-medium text-primary">#78155</td>
                                        <td class="px-3">Erro ao exportar relatório mensal</td>
                                        <td class="px-3">Roberto</td>
                                        <td class="px-3"><span
                                                class="badge rounded-pill fw-medium bg-warning-subtle">Em
                                                Aberto</span></td>
                                        <td class="px-3 fw-medium text-negative">88h 40m</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 fw-medium text-primary">#78002</td>
                                        <td class="px-3">API não retorna dados corretos</td>
                                        <td class="px-3">Mariana</td>
                                        <td class="px-3"><span
                                                class="badge rounded-pill fw-medium bg-positive-subtle">Resolvido</span>
                                        </td>
                                        <td class="px-3 fw-medium text-negative">75h 22m</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 fw-medium text-primary">#77984</td>
                                        <td class="px-3">Não consigo acessar minha conta</td>
                                        <td class="px-3">Lucas</td>
                                        <td class="px-3"><span
                                                class="badge rounded-pill fw-medium bg-positive-subtle">Resolvido</span>
                                        </td>
                                        <td class="px-3 fw-medium text-negative">68h 05m</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 fw-medium text-primary">#77901</td>
                                        <td class="px-3">Dúvida sobre integração com sistema X</td>
                                        <td class="px-3">Roberto</td>
                                        <td class="px-3"><span
                                                class="badge rounded-pill fw-medium bg-positive-subtle">Resolvido</span>
                                        </td>
                                        <td class="px-3 fw-medium text-warning">55h 30m</td>
                                    </tr>
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
                        <h3 class="card-title h5 fw-semibold">SLA de Resolução por Agente</h3>
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
                const donutData1 = {
                    value: 92,
                    color: '#007bff' // primary
                };
                const donutData2 = {
                    value: 85,
                    color: '#28a745' // positive
                };

                const lineData = {
                    labels: Array.from({
                        length: 30
                    }, (_, i) => i + 1), // Rótulos de 1 a 30
                    slaTotal: [88, 90, 92, 91, 89, 93, 94, 91, 90, 88, 85, 87, 89, 92, 95, 94, 93, 91, 90, 92, 94,
                        95, 96, 94, 92, 93, 95, 97, 96, 98
                    ],
                    slaResolucao: [85, 86, 88, 87, 85, 89, 90, 88, 87, 86, 82, 84, 85, 88, 91, 90, 89, 88, 87, 89,
                        90, 91, 92, 90, 89, 90, 92, 94, 93, 95
                    ]
                };

                const barDataAgentes = {
                    labels: ['Carlos', 'Beatriz', 'Mariana', 'Lucas', 'Juliana', 'Roberto',],
                    valores: [98, 95, 89, 72, 91, 65,]
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
                                data: [donutData1.value, 100 - donutData1.value],
                                backgroundColor: [donutData1.color, corBorda],
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
                                data: [donutData2.value, 100 - donutData2.value],
                                backgroundColor: [donutData2.color, corBorda],
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

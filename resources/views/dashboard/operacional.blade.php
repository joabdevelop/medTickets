<x-app-layout title="Operacional">



    <div class="d-flex min-vh-100 w-100">


        <!-- Main Content -->
        <main class="flex-grow-1 overflow-auto p-4 p-md-5">
            <div class="container-fluid mx-auto">
                <!-- Page Heading -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
                    <div class="d-flex flex-column gap-2">
                        <h1 class="text-dark-custom display-6 fw-bold mb-0">Dashboard de Desempenho</h1>
                        <p class="text-subtitle lead mb-0 fs-6">Acompanhe as métricas de performance da equipe de
                            atendimento.</p>
                    </div>
                    <!-- Chips/Filtros -->
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-primary d-flex align-items-center">Hoje</button>
                        <button class="btn btn-light border d-flex align-items-center text-dark-custom">Últimos 7
                            dias</button>
                        <button class="btn btn-light border d-flex align-items-center text-dark-custom">Mês
                            Atual</button>
                        <button class="btn btn-light border d-flex align-items-center text-dark-custom">
                            Período Customizado
                            <span class="material-symbols-outlined ms-2 fs-6">calendar_today</span>
                        </button>
                    </div>
                </div>

                <!-- Cards de Gráficos (Grid de 2 colunas no desktop) -->
                <div class="row g-4">

                    <!-- Card 1: Utilização / Ocupação (Barra Vertical) -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="card-title text-dark-custom fw-medium mb-1">Utilização / Ocupação do
                                    Agente</p>
                                <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">85%</h2>
                                <div class="d-flex gap-2 mb-4">
                                    <p class="text-subtitle small mb-0">Mês Atual</p>
                                    <p class="text-success small fw-medium mb-0">+2.5%</p>
                                </div>
                                <div style="height: 220px;">
                                    <canvas id="chartUtilizacao"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Taxa de Absenteísmo (Barra Horizontal) -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="card-title text-dark-custom fw-medium mb-1">Taxa de Absenteísmo por Agente
                                </p>
                                <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">5.2%</h2>
                                <div class="d-flex gap-2 mb-4">
                                    <p class="text-subtitle small mb-0">Mês Atual</p>
                                    <p class="text-danger small fw-medium mb-0">-1.0%</p>
                                </div>
                                <div style="height: 220px;">
                                    <canvas id="chartAbsenteismo"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Nível de Serviço (SLA) (Linha) -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="card-title text-dark-custom fw-medium mb-1">Nível de Serviço (SLA)</p>
                                <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">92%</h2>
                                <div class="d-flex gap-2 mb-4">
                                    <p class="text-subtitle small mb-0">Mês Atual</p>
                                    <p class="text-success small fw-medium mb-0">+5.0%</p>
                                </div>
                                <div style="height: 220px;">
                                    <canvas id="chartSLA"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Número de Interações (Barra Vertical) -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="card-title text-dark-custom fw-medium mb-1">Número de Interações por
                                    Agente</p>
                                <h2 class="card-subtitle text-dark-custom fw-bold display-5 mb-2">1,240</h2>
                                <div class="d-flex gap-2 mb-4">
                                    <p class="text-subtitle small mb-0">Mês Atual</p>
                                    <p class="text-success small fw-medium mb-0">+150</p>
                                </div>
                                <div style="height: 220px;">
                                    <canvas id="chartInteracoes"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Ranking -->
                <div class="mt-5 d-flex align-items-center justify-content-between">
                    <h2 class="text-dark-custom fs-4 fw-bold mb-0">Ranking de Produtividade dos Agentes</h2>
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
                                        Interações Resolvidas</th>
                                    <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">CSAT
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Tempo
                                        Médio Atendimento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-3 fw-medium text-dark">1</td>
                                    <td class="px-4 py-3 fw-medium text-dark">Carlos Pereira</td>
                                    <td class="px-4 py-3">310</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill text-bg-success py-1">98%</span>
                                    </td>
                                    <td class="px-4 py-3">4m 15s</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 fw-medium text-dark">2</td>
                                    <td class="px-4 py-3 fw-medium text-dark">Beatriz Costa</td>
                                    <td class="px-4 py-3">295</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill text-bg-success py-1">95%</span>
                                    </td>
                                    <td class="px-4 py-3">4m 40s</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 fw-medium text-dark">3</td>
                                    <td class="px-4 py-3 fw-medium text-dark">Juliana Almeida</td>
                                    <td class="px-4 py-3">280</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill text-bg-warning py-1">92%</span>
                                    </td>
                                    <td class="px-4 py-3">5m 02s</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 fw-medium text-dark">4</td>
                                    <td class="px-4 py-3 fw-medium text-dark">Lucas Martins</td>
                                    <td class="px-4 py-3">250</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill text-bg-warning py-1">90%</span>
                                    </td>
                                    <td class="px-4 py-3">5m 30s</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 fw-medium text-dark">5</td>
                                    <td class="px-4 py-3 fw-medium text-dark">Fernanda Lima</td>
                                    <td class="px-4 py-3">240</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill text-bg-danger py-1">85%</span>
                                    </td>
                                    <td class="px-4 py-3">6m 10s</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>


    </div>

    @push('scripts')
        <!-- 4. Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

        <!-- 5. Script para inicialização dos Gráficos -->
        <script>
            // Cores base
            const primaryColor = '#007bff';
            const primaryLight = 'rgba(0, 123, 255, 0.3)';
            const successColor = '#28a745';
            const grayColor = '#ced4da';

            document.addEventListener('DOMContentLoaded', function() {

                // --- GRÁFICO 1: Utilização / Ocupação (Barra Vertical) ---
                new Chart(document.getElementById('chartUtilizacao'), {
                    type: 'bar',
                    data: {
                        labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
                        datasets: [{
                                label: 'Ocupação (%)',
                                data: [50, 40, 30, 60],
                                backgroundColor: primaryLight,
                                borderColor: primaryColor,
                                borderWidth: 1,
                                stack: 'stack1',
                                borderRadius: 5
                            },
                            {
                                label: 'Utilização (%)',
                                data: [25, 35, 40, 25],
                                backgroundColor: primaryColor,
                                borderColor: primaryColor,
                                borderWidth: 1,
                                stack: 'stack1',
                                borderRadius: 5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + "%"
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    }
                });

                // --- GRÁFICO 2: Taxa de Absenteísmo (Barra Horizontal) ---
                new Chart(document.getElementById('chartAbsenteismo'), {
                    type: 'bar',
                    data: {
                        labels: ['Agente A', 'Agente B', 'Agente C', 'Agente D', 'Agente E'],
                        datasets: [{
                            label: 'Absenteísmo (%)',
                            data: [40, 20, 60, 90, 40],
                            backgroundColor: primaryColor,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y', // Define como barras horizontais
                        scales: {
                            x: {
                                beginAtZero: true,
                                max: 100,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value + "%"
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
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // --- GRÁFICO 3: Nível de Serviço (SLA) (Linha) ---
                new Chart(document.getElementById('chartSLA'), {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov',
                            'Dez'
                        ],
                        datasets: [{
                                label: 'SLA (%)',
                                data: [85, 88, 92, 90, 95, 93, 91, 94, 96, 92, 98, 97],
                                borderColor: primaryColor,
                                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointBackgroundColor: primaryColor
                            },
                            {
                                label: 'Meta (90%)',
                                data: [90, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90],
                                borderColor: successColor,
                                borderDash: [5, 5],
                                borderWidth: 2,
                                tension: 0.4,
                                fill: false,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: false,
                                min: 80,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + "%"
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    }
                });

                // --- GRÁFICO 4: Número de Interações (Barra Vertical Simples) ---
                new Chart(document.getElementById('chartInteracoes'), {
                    type: 'bar',
                    data: {
                        labels: ['Agente A', 'Agente B', 'Agente C', 'Agente D', 'Agente E'],
                        datasets: [{
                            label: 'Interações',
                            data: [200, 100, 300, 150, 490],
                            backgroundColor: [primaryLight, primaryLight, primaryLight, primaryLight,
                                primaryColor
                            ],
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>

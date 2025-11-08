<x-app-layout title="Desempenho de Equipe">

  
    <!-- Este 'main' representa o conteúdo principal da sua página -->
        <div class="container-lg">

            <!-- Cabeçalho e Filtros de Data -->
            <header class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-4 mb-5">
                <h1 class="h2 fw-bold mb-0">Dashboard de Desempenho Geral</h1>

                <!-- Filtros de Data (convertidos para btn-group) -->
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group p-1 bg-white rounded-3 shadow-sm" role="group" aria-label="Filtro de data">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off"
                            checked>
                        <label class="btn btn-primary px-3 rounded-2" for="btnradio1">Hoje</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-secondary border-0" for="btnradio2">7 Dias</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-secondary border-0" for="btnradio3">30 Dias</label>
                    </div>
                    <button class="btn btn-light bg-white shadow-sm px-3 rounded-3">
                        <i class="bi bi-calendar-month me-1"></i> Personalizado
                    </button>
                </div>
            </header>

            <!-- Cards de Estatísticas -->
            <section class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-4 mb-5">

                <!-- Card TMA -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-timer fs-5 me-2"></i>
                                <span class="fw-semibold small">TMA</span>
                            </div>
                            <h2 class="fw-bold my-1">5m 32s</h2>
                            <div class="d-flex align-items-center text-danger small mt-1">
                                <i class="bi bi-arrow-down-short"></i>
                                <span class="fw-medium">-1.2%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card TME -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-hourglass-split fs-5 me-2"></i>
                                <span class="fw-semibold small">TME</span>
                            </div>
                            <h2 class="fw-bold my-1">2m 15s</h2>
                            <div class="d-flex align-items-center text-success small mt-1">
                                <i class="bi bi-arrow-up-short"></i>
                                <span class="fw-medium">+3.5%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Taxa de Resolução -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-check-circle fs-5 me-2"></i>
                                <span class="fw-semibold small">Taxa de Resolução</span>
                            </div>
                            <h2 class="fw-bold my-1">92.5%</h2>
                            <div class="d-flex align-items-center text-success small mt-1">
                                <i class="bi bi-arrow-up-short"></i>
                                <span class="fw-medium">+2.1%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Volume de Atendimentos -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-headset fs-5 me-2"></i>
                                <span class="fw-semibold small">Volume de Atendimentos</span>
                            </div>
                            <h2 class="fw-bold my-1">1,254</h2>
                            <div class="d-flex align-items-center text-success small mt-1">
                                <i class="bi bi-arrow-up-short"></i>
                                <span class="fw-medium">+15%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Backlog Atual -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-inbox fs-5 me-2"></i>
                                <span class="fw-semibold small">Backlog Atual</span>
                            </div>
                            <h2 class="fw-bold my-1">87</h2>
                            <div class="d-flex align-items-center text-danger small mt-1">
                                <i class="bi bi-arrow-down-short"></i>
                                <span class="fw-medium">-5%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Gráficos -->
            <section class="row g-4">

                <!-- Gráfico de Barras (Volume por Canal) -->
                <div class="col-lg-8">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="card-title fs-5 fw-semibold mb-4">Volume de Atendimentos por Departamento </h3>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="barChartCanal"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Donut (Taxa de Resolução) -->
                <div class="col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center text-center">
                            <h3 class="card-title fs-5 fw-semibold mb-3">Taxa de Resolução</h3>

                            <!-- Container para o gráfico e o texto centralizado -->
                            <div class="chart-donut-container">
                                <canvas id="donutChartResolucao"></canvas>
                                <div class="chart-donut-label">
                                    <h3 class="fw-bold mb-0">92.5%</h3>
                                    <p class="text-muted small mb-0">Meta: 90%</p>
                                </div>
                            </div>

                            <p class="text-muted small mt-3 mb-0 px-3">
                                A equipe está superando a meta de resolução de chamados no primeiro contato.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    <!-- 7. Script dos Gráficos -->

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                console.log('Abriu js do Equipe');

                // Dados de exemplo (substitua pelos seus dados reais)
                const dadosBarra = {
                    labels: ['Telefone', 'Chat', 'E-mail', 'WhatsApp'],
                    valores: [60, 30, 75, 90] // Baseado nas alturas (60%, 30%, 75%, 90%)
                };

                const dadosDonut = {
                    resolvido: 92.5,
                    meta: 90
                };
                const pendente = Math.max(0, 100 - dadosDonut.resolvido);

                // Configuração de Cores
                const corPrimaria = '#007bff';
                const corPositiva = '#28a745';
                const corBorda = '#e2e8f0';
                const corTextoSecundario = '#6c757d';

                // --- Gráfico de Barras ---
                const ctxBar = document.getElementById('barChartCanal');
                if (ctxBar) {
                    new Chart(ctxBar.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: dadosBarra.labels,
                            datasets: [{
                                label: 'Volume',
                                data: dadosBarra.valores,
                                backgroundColor: 'rgba(0, 123, 255, 0.2)', // primary/20
                                borderColor: corPrimaria,
                                borderWidth: 1,
                                borderRadius: 6,
                                hoverBackgroundColor: 'rgba(0, 123, 255, 0.4)'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false // Esconde a legenda
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: corBorda // Cor da grade
                                    },
                                    ticks: {
                                        color: corTextoSecundario // Cor dos números
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false // Esconde grade vertical
                                    },
                                    ticks: {
                                        color: corTextoSecundario // Cor dos labels
                                    }
                                }
                            }
                        }
                    });
                }

                // --- Gráfico de Donut ---
                const ctxDonut = document.getElementById('donutChartResolucao');
                if (ctxDonut) {
                    new Chart(ctxDonut.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Resolvido', 'Pendente'],
                            datasets: [{
                                data: [dadosDonut.resolvido, pendente],
                                backgroundColor: [
                                    corPositiva, // Verde para "Resolvido"
                                    corBorda // Cinza claro para "Pendente"
                                ],
                                borderColor: 'transparent', // Sem borda entre as fatias
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '75%', // Controla o tamanho do "buraco"
                            plugins: {
                                legend: {
                                    display: false // Esconde a legenda
                                },
                                tooltip: {
                                    enabled: true // Mostra tooltip ao passar o mouse
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>

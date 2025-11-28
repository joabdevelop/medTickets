<div class="container-lg">
    <header class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-4 mb-5">
        <h1 class="h2 fw-bold mb-0">Dashboard - Desempenho da Empresa</h1>

        <form method="GET" action="{{ route('dashboard.equipe') }}" class="d-flex align-items-center gap-2" role="group">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
                <input type="date" name="inicio" value="{{ $dataInicio }}">
                <input type="date" name="fim" value="{{ $dataFim }}">
                <button type="submit" class="btn btn-primary d-flex align-items-center">Aplicar Filtro</button>
            </div>
        </form>
    </header>

    @php
        $totalTickets = $dados->sum('total');
        $totalConcluidos = $dados->sum('concluidos');
        $totalDevolvidos = $dados->sum('devolvidos');
        $totalSLAok = $dados->sum('sla_ok');
        $tempoTotal = $dados->sum('tempo_total');
        $ticketsComTempo = $dados->sum('tickets_tempo');

        $taxaResolucao = $totalTickets > 0 ? round(($totalConcluidos / $totalTickets) * 100, 1) : 0;
        $taxaDevolvidos = $totalTickets > 0 ? round(($totalDevolvidos / $totalTickets) * 100, 1) : 0;
        $taxaPendente = max(0, 100 - ($taxaResolucao + $taxaDevolvidos));

        $cumprimentoSLA = $totalTickets > 0 ? round(($totalSLAok / $totalTickets) * 100, 1) : 0;

        $tmaSegundos = $ticketsComTempo > 0 ? $tempoTotal / $ticketsComTempo : 0;
        $tmaHoras = floor($tmaSegundos / 3600);
        $tmaMinutos = floor(($tmaSegundos % 3600) / 60);
        $tmaRestante = $tmaSegundos % 60;
    @endphp

    <section class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-4 mb-5">
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bi bi-timer fs-5 me-2"></i>
                        <span class="fw-semibold small">TMA</span>
                    </div>
                    <h2 class="fw-bold my-1">
                        @if ($tmaHoras > 0)
                            {{ $tmaHoras }}h {{ $tmaMinutos }}m
                        @elseif ($tmaMinutos > 0)
                            {{ $tmaMinutos }}m {{ $tmaRestante }}s
                        @else
                            {{ $tmaRestante }}s
                        @endif
                    </h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bi bi-check-circle fs-5 me-2"></i>
                        <span class="fw-semibold small">Taxa de Resolução</span>
                    </div>
                    <h2 class="fw-bold my-1">{{ $taxaResolucao }}%</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bi bi-flag fs-5 me-2"></i>
                        <span class="fw-semibold small">Cumprimento SLA</span>
                    </div>
                    <h2 class="fw-bold my-1">{{ $cumprimentoSLA }}%</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bi bi-headset fs-5 me-2"></i>
                        <span class="fw-semibold small">Qtd. de Atendimentos</span>
                    </div>
                    <h2 class="fw-bold my-1">{{ number_format($totalTickets, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bi bi-inbox fs-5 me-2"></i>
                        <span class="fw-semibold small">Backlog Atual</span>
                    </div>
                    <h2 class="fw-bold my-1">{{ number_format($totalTickets - $totalConcluidos, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h3 class="card-title fs-5 fw-semibold mb-4">Volume de Atendimentos por Departamento</h3>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="barChartCanal"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center text-center">
                    <h3 class="card-title fs-5 fw-semibold mb-3">Taxa de Resolução</h3>
                    <div class="chart-donut-container">
                        <canvas id="donutChartResolucao"></canvas>
                        <div class="chart-donut-label">
                            <h3 class="fw-bold mb-0">{{ $taxaResolucao }}%</h3>
                            <p class="text-muted small mb-0">Meta: 90%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="card shadow-sm mt-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Rank</th>
                        <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Agente</th>
                        <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Tickets Concluídos</th>
                        <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">SLA/Qualidade</th>
                        <th scope="col" class="px-4 py-3 text-uppercase small text-secondary">Tempo Médio Atendimento</th>
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
                            <td class="px-4 py-3"><span class="badge rounded-pill {{ $badgeClass }} py-1">{{ number_format($item->sla_percentual, 2) }}%</span></td>
                            <td class="px-4 py-3">{{ $tempoFormatado }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Nenhuma métrica de ranking encontrada para o período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dados = @json($dados);
            const labels = dados.map(d => d.origem_sigla_depto);
            const valores = dados.map(d => d.total);

            const ctxBar = document.getElementById('barChartCanal');
            if (ctxBar) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: { labels: labels, datasets: [{ label: 'Atendimentos', data: valores, backgroundColor: 'rgba(0, 123, 255, 0.3)', borderColor: '#007bff', borderWidth: 1, borderRadius: 6 }] },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, datalabels: { anchor: 'end', align: 'top', color: '#000', font: { weight: 'bold', size: 12 }, clip: false, offset: 6, formatter: value => value.toLocaleString('pt-BR') } }, layout: { padding: { top: 20 } }, scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' } }, x: { grid: { display: false } } } },
                    plugins: [ChartDataLabels]
                });
            }

            const resolvido = {{ $taxaResolucao }};
            const devolvido = {{ $taxaDevolvidos }};
            const pendente = {{ $taxaPendente }};

            const ctxDonut = document.getElementById('donutChartResolucao');
            if (ctxDonut) {
                new Chart(ctxDonut, { type: 'doughnut', data: { labels: ['Concluído', 'Devolvido', 'Pendente'], datasets: [{ data: [resolvido, devolvido, pendente], backgroundColor: ['#28a745', '#ffc107', '#b3b7bd'], borderWidth: 0 }] }, options: { cutout: '50%', plugins: { legend: { display: false }, datalabels: { color: '#000 ', font: { weight: 'bold', size: 14 }, formatter: (value, context) => { const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0); const percentage = ((value / total) * 100).toFixed(0) + '%'; return percentage; } }, tooltip: { enabled: true, callbacks: { label: (ctx) => `${ctx.label}: ${ctx.formattedValue}%` } } } }, plugins: [ChartDataLabels] });
            }
        });
    </script>

</div>

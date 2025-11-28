<div class="container-lg">
    @include('components.alertas')
    <header class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">
        <div>
            <h1 class="h2 fw-bold mb-1">Dashboard - SLA </h1>
            <p class="text-muted mb-0">Acompanhe os principais indicadores de desempenho da equipe.</p>
        </div>
        <form method="GET" action="{{ route('dashboard.sla') }}" class="d-flex align-items-center gap-2" role="group">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
                <input type="date" name="inicio" value="{{ $dataInicio }}">
                <input type="date" name="fim" value="{{ $dataFim }}">
                <button type="submit" class="btn btn-primary d-flex align-items-center">Aplicar Filtro</button>
            </div>
        </form>
    </header>

    <div class="row row-cols-1 row-cols-lg-3 g-4">
        <div class="col">
            <div class="card h-100 rounded-xl shadow-sm custom-border-card card-border-primary">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start text-muted">
                        <h3 class="h6 text-muted fw-medium">Tempo de Resolução Médio</h3>
                        <i class="bi bi-timer fs-5"></i>
                    </div>
                    <div>
                        <p class="h1 fw-bold my-2">{{ $tempoMedioResolucao }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded-xl shadow-sm custom-border-card card-border-warning">
                <div class="card-body p-4 text-center">
                    <h3 class="h6 text-muted fw-medium">SLA de Primeira Resposta</h3>
                    <div class="chart-container mx-auto" style="max-height: 160px; position: relative;">
                        <canvas id="donutSlaResposta"></canvas>
                        <div class="chart-donut-label" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <h3 class="h2 fw-bold mb-0">{{ $percentualSlaResposta }}%</h3>
                            <span class="small text-muted">Cumprido</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded-xl shadow-sm custom-border-card card-border-success">
                <div class="card-body p-4 text-center">
                    <h3 class="h6 text-muted fw-medium">SLA Cumprido (Resolução)</h3>
                    <div class="chart-container mx-auto" style="max-height: 160px; position: relative;">
                        <canvas id="donutSlaResolucao"></canvas>
                        <div class="chart-donut-label" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <h3 class="h2 fw-bold mb-0">{{ $percentualSlaResolucao }}%</h3>
                            <span class="small text-muted">Cumprido</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-xl-8">
            <div class="card shadow-sm rounded-xl">
                <div class="card-body p-4 p-md-5">
                    <h3 class="card-title h5 fw-semibold mb-4">Top 10 Tickets com Maior Tempo de Resolução</h3>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle caption-top">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3 px-3">Ticket</th>
                                    <th scope="col" class="py-3 px-3">Serviço</th>
                                    <th scope="col" class="py-3 px-3">Agente</th>
                                    <th scope="col" class="py-3 px-3">Status</th>
                                    <th scope="col" class="py-3 px-3">Tempo de Resolução</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topTicketsLentos as $ticket)
                                    @php $statusEnum = \App\Enums\StatusTickets::tryFrom($ticket->status_final); @endphp
                                    <tr>
                                        <td class="px-3 fw-medium text-primary">{{ $ticket->numero_ticket }}</td>
                                        <td class="px-3">{{ Str::limit($ticket->tipo_servico->nome_servico, 40) }}</td>
                                        <td class="px-3">{{ $ticket->user_executante->nome ?? 'N/A' }}</td>
                                        <td class="px-3">
                                            @if ($statusEnum)
                                                <span class="badge rounded-pill fw-medium {{ $statusEnum->getBootstrapClass(true) }}">{{ $statusEnum->value }}</span>
                                            @else
                                                <span class="badge rounded-pill fw-medium bg-secondary-subtle text-secondary-emphasis">{{ $ticket->status_final }}</span>
                                            @endif
                                        </td>
                                        <td class="px-3 fw-medium text-negative">{{ gmdate('H\\h i\\m', $ticket->tempo_execucao * 60) }}</td>
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
        <div class="col-xl-4 h-100">
            <div class="card shadow-sm rounded-xl h-100 ">
                <div class="card-body h-100">
                    <h3 class="card-title h5 fw-semibold mb-1">SLA de Resolução por Agente</h3>
                    <p class="card-subtitle text-muted small mb-4">Neste mês</p>
                    <div style="height: 320px; overflow-y: auto;">
                        <canvas id="barChartAgentes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const donutSlaRespostaData = { value: {{ $percentualSlaResposta }}, color: '#007bff' };
            const donutSlaResolucaoData = { value: {{ $percentualSlaResolucao }}, color: '#28a745' };

            const barDataAgentes = { labels: @json($agentesLabels), valores: @json($agentesValores) };

            const corPositiva = '#28a745';
            const corNegativa = '#dc3545';
            const corAlerta = '#ffc107';
            const corPrimaria = '#007bff';
            const corBorda = '#e2e8f0';
            const corTextoSecundario = '#6c757d';

            function getBarColor(value) {
                if (value >= 90) return corPositiva;
                if (value >= 80) return corAlerta;
                return corNegativa;
            }

            const ctxDonut1 = document.getElementById('donutSlaResposta');
            if (ctxDonut1) {
                new Chart(ctxDonut1, { type: 'doughnut', data: { datasets: [{ data: [donutSlaRespostaData.value, 100 - donutSlaRespostaData.value], backgroundColor: [donutSlaRespostaData.color, corBorda], borderColor: 'transparent' }] }, options: { responsive: true, maintainAspectRatio: false, cutout: '80%', plugins: { legend: { display: false }, tooltip: { enabled: false } } } });
            }

            const ctxDonut2 = document.getElementById('donutSlaResolucao');
            if (ctxDonut2) {
                new Chart(ctxDonut2, { type: 'doughnut', data: { datasets: [{ data: [donutSlaResolucaoData.value, 100 - donutSlaResolucaoData.value], backgroundColor: [donutSlaResolucaoData.color, corBorda], borderColor: 'transparent' }] }, options: { responsive: true, maintainAspectRatio: false, cutout: '80%', plugins: { legend: { display: false }, tooltip: { enabled: false } } } });
            }

            const ctxBar = document.getElementById('barChartAgentes');
            if (ctxBar) {
                new Chart(ctxBar, { type: 'bar', data: { labels: barDataAgentes.labels, datasets: [{ label: 'SLA de Resolução', data: barDataAgentes.valores, backgroundColor: barDataAgentes.valores.map(v => getBarColor(v)), borderRadius: 4 }] }, options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { callbacks: { label: (context) => context.raw + '%' } } }, scales: { x: { beginAtZero: true, max: 100, grid: { color: corBorda }, ticks: { color: corTextoSecundario, callback: (value) => value + '%' } }, y: { grid: { display: false }, ticks: { color: corTextoSecundario } } } } });
            }
        });
    </script>

</div>

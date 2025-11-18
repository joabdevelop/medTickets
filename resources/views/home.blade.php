<x-app-layout title="Página Inicial">

    <div class="d-flex">
        <!-- Cards de Estatísticas -->
        @php
            $totalTickets = $dados->sum('total');
            $totalConcluidos = $dados->sum('concluidos');
            $totalDevolvidos = $dados->sum('devolvidos');
            $totalSLAok = $dados->sum('sla_ok');
            $tempoTotal = $dados->sum('tempo_total');
            $ticketsComTempo = $dados->sum('tickets_tempo');

            // Cálculos
            $taxaResolucao = $totalTickets > 0 ? round(($totalConcluidos / $totalTickets) * 100, 1) : 0;
            $taxaDevolvidos = $totalTickets > 0 ? round(($totalDevolvidos / $totalTickets) * 100, 1) : 0;
            $taxaPendente = max(0, 100 - ($taxaResolucao + $taxaDevolvidos));

            $cumprimentoSLA = $totalTickets > 0 ? round(($totalSLAok / $totalTickets) * 100, 1) : 0;

            $tmaSegundos = $ticketsComTempo > 0 ? $tempoTotal / $ticketsComTempo : 0;
            $tmaHoras = floor($tmaSegundos / 3600);
            $tmaMinutos = floor(($tmaSegundos % 3600) / 60);
            $tmaRestante = $tmaSegundos % 60;
        @endphp
        <main class="flex-grow-1 container-fluid">

            <section class="container-section">
                <div class="container-list px-4">
                    <!-- Título Dinâmico (Aqui está a implementação do cumprimento) -->
                    <div class="flex flex-col gap-1 mt-2">
                        <!-- ID 'greetingTitle' é onde o JS insere o texto -->
                        <h1 class="text-dark fs-3 fw-bold m-0">
                            {{ $greeting }}, {{ $userName }}!
                        </h1>
                        <p class="text-gray-500 text-sm">Visão geral do desempenho dos seus atendimentos do mês.
                        </p>
                    </div>
                    <div class="d-flex flex-column  justify-content-between ">

                        <div class="small  ">
                            <span class="fw-bolder text-primary-emphasis">
                                Data inicio:
                            </span>
                            <span class="text-black-50 mt-0">{{ $dataInicio }} </span>
                            <span class="fw-bolder text-primary-emphasis">
                                | Data fim:
                            </span>
                            <span class="text-black-50">{{ $dataFim }} </span>
                        </div>

                    </div>
                </div>
            </section>



            <section class="row g-4 mb-4 mt-1 px-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card bg-white p-4 h-100 shadow-sm custom-border-card card-border-danger">
                        <p class="text-secondary fw-medium mb-1">Total de Solicitações no Mês</p>
                        <p class="text-dark fs-3 fw-bold mb-0">{{ $totalTickets }}</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card bg-white p-4 h-100 shadow-sm custom-border-card card-border-success">
                        <p class="text-secondary fw-medium mb-1">Qtd de Atendimentos em aberto</p>
                        <p class="text-dark fs-3 fw-bold mb-0">
                            {{ number_format($totalTickets - $totalConcluidos, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card bg-white p-4 h-100 shadow-sm custom-border-card card-border-primary">
                        <p class="text-secondary fw-medium mb-1">Taxa de SLA Satisfeita</p>
                        <p class="text-dark fs-3 fw-bold mb-0">{{ $cumprimentoSLA }}%</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card bg-white p-4 h-100 shadow-sm custom-border-card card-border-warning">
                        <p class="text-secondary fw-medium mb-1">Tempo Médio de Resolução</p>
                        <p class="text-dark fs-3 fw-bold mb-0">{{ $taxaResolucao }}%</p>
                    </div>
                </div>
            </section>

            <section class="table-section">

                <div class="table-list table-responsive">
                    <div class="card-body p-2 p-md-2">
                        <h3 class="card-title h5 fw-semibold mt-4">Top 10 Tickets com Maior Tempo de Resolução</h3>
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle caption-top">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3 px-3">Ticket</th>
                                        <th scope="col" class="py-3 px-3">Serviço</th>
                                        <th scope="col" class="py-3 px-3">Status</th>
                                        <th scope="col" class="py-3 px-3">Tempo de Resolução</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    @endphp
                                    @forelse ($topTickets as $ticket)
                                        @php
                                            $statusEnum = \App\Enums\StatusTickets::tryFrom($ticket->status_final);
                                        @endphp
                                        <tr>
                                            <td class="px-3 fw-medium text-primary">{{ $ticket->numero_ticket }}</td>
                                            <td class="px-3">{{ Str::limit($ticket->tipo_servico->nome_servico, 40) }}
                                            </td>
                                            <td class="px-3">
                                                @if ($statusEnum)
                                                    <span
                                                        class="badge rounded-pill fw-medium {{ $statusEnum->getBootstrapClass(true) }}">
                                                        {{ $statusEnum->value }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill fw-medium bg-secondary-subtle text-secondary-emphasis">
                                                        {{ $ticket->status_final }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 fw-medium text-negative">
                                                {{ gmdate('H\h i\m', $ticket->tempo_execucao * 60) }}</td>
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
            </section>
        </main>
    </div>

    @push('scripts')
        <script></script>
    @endpush

</x-app-layouT>

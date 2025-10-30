<x-app-layout title="Tickets">

    <body>
        <section class="container-section">
            <div class="container-list">
                <h1>Tickets - Fila de Solicitações</h1>

                <form method="GET" action="{{ route('ticket.index') }}" class="input-group w-25">

                    <input type="search" name="search" id="search" value="{{ old('search') ?? request('search') }}"
                        class="form-control rounded-start" placeholder="Digite o numero do ticket" aria-label="Buscar">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">search</i>
                    </button>
                </form>

                <!-- Button trigger modal -->

                <button type="button" class=" btn btn-outline-primary create " data-bs-toggle="modal"
                    data-bs-target="#createSolicitaServicoModal" data-user-id="{{ Auth::user()->id }}"
                    data-user-departamento="{{ Auth::user()->profissional?->departamento?->sigla_depto }}"
                    title="Incluir">
                    Adicionar
                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">group_add</i>
                </button>
            </div>
        </section>
        <section class="table-section">
            <div class="table-list">
                <!-- Alertas de sucesso ou erro -->
                @include('components.alertas')

                <table class="table table-hover cursor-pointer table-responsive">
                    <thead>
                        <tr>
                            <th>Numero do Ticket</th>
                            <th>Data de Abertura</th>
                            <th>Serviço Solicitado</th>
                            <th>Empresa</th>
                            <th>Solicitante</th>
                            <th>Executante</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->numero_ticket }}</td>
                                <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td>{{ $ticket->tipo_servico->nome_servico }}</td>
                                <td>{{ $ticket->empresa->nome_fantasia }}</td>
                                <td>{{ $ticket->user_solicitante->nome }}</td>
                                <td>{{ $ticket->user_executante->nome ?? 'Na fila de espera' }}</td>
                                <td>{{ $ticket->tipo_servico->prioridade->label() }}</td>
                                <td>
                                    @php
                                        // 1. Converte a string do banco de dados para o objeto Enum
                                        // Use tryFrom() para evitar erro se a string for inválida
                                        $statusEnum = \App\Enums\StatusTickets::tryFrom($ticket->status_final);
                                    @endphp

                                    @if ($statusEnum)
                                        <span class="badge {{ $statusEnum->getBootstrapClass() }}">
                                            {{ $statusEnum->value }}
                                        </span>
                                    @else
                                        {{ $ticket->status_final }} {{-- Exibe como texto simples se a conversão falhar --}}
                                    @endif
                                </td>
                                <td class="d-flex justify-content-center">

                                    <!-- Action Buttons -->

                                    <div class="btn-group btn-group-sm">
                                        <!-- Botão Alterar -->
                                        <a href="#" class="atender" data-bs-toggle="modal"
                                            data-bs-target="#resolverTicketsModal" data-id="{{ $ticket->id }}">
                                            <i class="bi bi-bookmark-check fs-5" data-bs-toggle="tooltip"
                                                title="Atender Chamado"></i>
                                        </a>
                                    </div>

                                    @if ($ticket->status_final == 'Aberto')
                                        <a href="#" class="delete" data-id="{{ $ticket->id }}"
                                            data-numero-ticket="{{ $ticket->numero_ticket }}" data-bs-toggle="modal"
                                            data-bs-target="#deleteSolicitaServicoModal">
                                            <i class="material-icons text-danger" data-bs-toggle="tooltip"
                                                title="Excluir">&#xE872;</i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" class="delete disabled" tabindex="-1"
                                            aria-disabled="true" style="pointer-events:none; opacity:0.5;">
                                            <i class="material-icons text-danger"
                                                title="Excluir não permitido">&#xE872;</i>
                                        </a>
                                    @endif

                                </td>
                            </tr>

                        @empty
                            <td colspan="8" class="text-center">Nenhum grupo encontrado.</td>
                        @endforelse
                    </tbody>
                </table>
                <div class="clearfix">
                    {{ $tickets->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
        <!-- Modals -->
        @include('ticket.createModal')
        @include('ticket.resolverModal')
        @include('ticket.deleteModal')
    </body>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                $(document).on('click', '.atender', function() {
                    // Captura o ID do ticket do link/botão clicado (que tem data-id)
                    const ticketId = $(this).data('id');

                    console.log('Ticket_Id capturado na abertura:', ticketId);

                    // Armazena o ID em um campo oculto DENTRO do modal
                    $('#resolver_ticket_id').val(ticketId);

                    // ... preenche o resto do modal ...
                });


                // URL da rota que aceita o atendimento (Você precisa ajustar a rota se for diferente)
                // Usamos um placeholder {id} que será substituído pelo ID real do ticket.

                // Use a base estática (sem o ID)
                const aceitarAtendimentoBase =
                    "{{ url('ticket/atender') }}"; // gera: http://medtickets.test/ticket/atender/



                // 1. Intercepta o clique no botão "Atender"
                $(document).on('click', '#ModalBodyButton', function(e) {
                    // Previne o comportamento padrão do botão submit (que fecharia o modal ou faria um submit de formulário)
                    e.preventDefault();

                    const button = $(this);
                    const originalText = button.html(); // Salva o HTML original para restaurar em caso de erro

                    // Assumimos que o ID do ticket está armazenado em algum campo oculto ou em um atributo data
                    // AJUSTE ESSA LINHA: Você deve obter o ID do ticket do modal de alguma forma.
                    const ticketId = $('#resolver_ticket_id').val();

                    // Verifica se o ticketId foi encontrado
                    if (!ticketId) {
                        console.error('ID do ticket não encontrado. Abortando a requisição.');
                        return;
                    }

                    // 2. Substitui o placeholder na rota pelo ID real
                    const finalUrl = `${aceitarAtendimentoBase}/${ticketId}`;

                    // Muda o texto do botão e desabilita temporariamente
                    button.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...'
                    );

                    // 3. Envia a requisição AJAX para o Laravel
                    $.ajax({
                        url: finalUrl,
                        method: 'POST', // Use POST ou PUT/PATCH, dependendo da sua rota
                        data: {
                            _token: '{{ csrf_token() }}', // Necessário para proteção CSRF no Laravel
                            // Você pode adicionar outros dados se necessário
                        },
                        success: function(response) {
                            // A rota deve retornar status 200 e, idealmente, um JSON de sucesso
                            if (response.status === 200 || response.success === true) {

                                // 4. Sucesso: Altera o botão para "Em Andamento" e bloqueia
                                button.removeClass('btn-success').addClass('btn-secondary');
                                button.html('<i class="bi bi-person-fill-gear"></i> Em Andamento');
                                button.prop('disabled', true); // Mantém o botão bloqueado

                                // Opcional: Mostra uma notificação de sucesso
                                console.log('Atendimento aceito com sucesso!');

                            } else {
                                // Erro: Restaurar o botão original e mostrar mensagem
                                console.error('Erro ao aceitar atendimento:', response.message ||
                                    'Resposta inválida do servidor.');
                                button.prop('disabled', false).html(originalText);
                                // Opcional: Mostrar erro na tela
                                alert('Erro: ' + (response.message || 'Falha na operação.'));
                            }
                        },
                        error: function(xhr, status, error) {
                            // Erro de rede ou erro HTTP (4xx, 5xx)
                            console.error("AJAX Error: ", error);

                            // Restaurar o botão original
                            button.prop('disabled', false).html(originalText);
                            alert('Erro na comunicação com o servidor. Tente novamente.');
                        }
                    });
                });



            });
        </script>
    @endpush
</x-app-layout>

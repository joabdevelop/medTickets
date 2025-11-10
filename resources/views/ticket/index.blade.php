<x-app-layout title="Tickets">

    <body>
        {{-- Titulo do Ticket --}}
        <section class="container-section">
            {{-- 1. BLOCO PHP NO INÍCIO DA SEÇÃO --}}
            @php
                // 1. Encontra qual parâmetro de filtro está preenchido na URL
                $filtroAtivo = '';

                // A ordem de checagem é importante. Priorize o filtro que deseja.
                if (request()->filled('search')) {
                    $filtroAtivo = 'campo-search';
                } elseif (request()->filled('select_statusFinal') && request('select_statusFinal') !== 'Todos') {
                    $filtroAtivo = 'campo-status';
                } elseif (request()->filled('data_ticket')) {
                    $filtroAtivo = 'campo-data';
                } else {
                    // Padrão, se nenhum filtro estiver ativo (mostra o campo de busca por padrão)
                    $filtroAtivo = 'campo-search';
                }
            @endphp
            <div class="container-list">
                <h1>Tickets - Fila de Solicitações</h1>


                <div class="container-search">
                    <form method="POST" action="{{ route('metricas.consolidadas') }}" class="me-2">
                        @csrf
                        <button type="submit" class="btn btn-info" data-bs-toggle="tooltip"
                            title="Processar Métricas Consolidadas">
                            <i class="bi bi-calculator"></i>
                        </button>
                    </form>
                    <!-- Filtar por Numero do tickets, status e data -->
                    <form method="GET" action="{{ route('ticket.index') }}"
                        class="row g-2 d-flex align-items-center justify-content-center form-floating form-cadastro form-search">
                        <div class="input-group">
                            <!-- Campo de busca -->
                            <div class="col-md-4 form-floating filtro-campo" id="campo-search">
                                <input type="search" name="search" id="search"
                                    value="{{ old('search') ?? request('search') }}" class="form-control rounded-start"
                                    placeholder="Digite o numero" aria-label="Buscar">
                                <label for="search" class="form-label">numero do ticket</label>
                            </div>

                            <!-- Status -->
                            <div class="col-md-3 form-floating filtro-campo" id="campo-status">
                                <select name="select_statusFinal" id="select_statusFinal"
                                    class="form-select form-control">
                                    <option value="Todos" @selected(request('select_statusFinal') == 'Todos' || !request('select_statusFinal'))>
                                        Todos
                                    </option>
                                    @foreach ($statusFinals as $statusFinal)
                                        <option value="{{ $statusFinal->value }}" {{-- Seleciona a opção se ela for igual ao valor na URL --}}
                                            @selected(old('select_statusFinal', request('select_statusFinal')) == $statusFinal->value)>
                                            {{ $statusFinal->value }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="select_statusFinal" class="form-label">Status</label>
                            </div>

                            <!-- Data -->
                            <div class="col-md-3 form-floating filtro-campo" id="campo-data">
                                <input type="date" class="form-control" id="data_ticket" name="data_ticket"
                                    value="{{ old('data_ticket', request('data_ticket')) }}">
                                <label for="data_ticket" class="form-label">Data</label>
                            </div>
                            <button type="button"
                                class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="p-2" id="filtro-selecionado-texto">Filtrar por</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#" data-target="campo-search">
                                        Numero do ticket
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-target="campo-status">
                                        Status do ticket
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-target="campo-data">
                                        Data do ticket
                                    </a>
                                </li>
                            </ul>
                            <button type="submit" class="btn btn-outline-secondary">Procurar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="table-section">
            <div class="table-responsive table-list">
                <!-- Alertas de sucesso ou erro -->
                @include('components.alertas')

                <table class="table cursor-pointer table-borderless table-hover align-middle caption-top">
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
                            <th>Sla</th>
                            <th>Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->numero_ticket }}</td>
                                <td>{{ $ticket->data_solicitacao->format('d/m/Y') }}</td>
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
                                <td>
                                    @if ( $ticket->cumpriu_sla )
                                        <span class="badge bg-success">Sim</span>
                                    @else
                                        <span class="badge bg-danger">Não</span>
                                    @endif
                                </td>
                                <td>

                                    <!-- Action Buttons -->

                                    <div class="btn-group btn-group-sm">
                                        <!-- Botão Alterar -->
                                        <a href="#" class="atender" data-bs-toggle="modal"
                                            data-bs-target="#resolverTicketsModal" data-id="{{ $ticket->id }}"
                                            data-status-ticket="{{ $ticket->status_final }}"
                                            data-data_solicitacao="{{ $ticket->data_solicitacao->format('d/m/Y') }}"
                                            data-numero_ticket="{{ $ticket->numero_ticket }}"
                                            data-user_id_solicitante="{{ $ticket->user_solicitante->nome }}"
                                            data-empresa_id="{{ $ticket->empresa->nome_fantasia }}"
                                            data-tipo_servico_id="{{ $ticket->tipo_servico->nome_servico }}"
                                            data-descricao_servico="{{ $ticket->descricao_servico }}"
                                            data-observacoes="{{ $ticket->observacoes }}"
                                            data-status-class="{{ \App\Enums\StatusTickets::tryFrom($ticket->status_final)?->getBootstrapClass() }}">
                                            <i class="bi bi-bookmark-check fs-5" data-bs-toggle="tooltip"
                                                title="Atender Chamado"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <td colspan="8" class="text-center">Nenhum grupo encontrado.</td>
                        @endforelse
                    </tbody>
                </table>
                <div class="clearfix">
                    {{ $tickets->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
        <!-- Modals -->
        @include('ticket.resolverModal')
    </body>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // 1. Função NL2BR (adicione no seu arquivo JS ou no bloco <script>)
                function nl2br(str) {
                    if (typeof str === 'undefined' || str === null) {
                        return '';
                    }
                    // O regex /\r?\n/g encontra \r\n ou \n e os substitui por <br>
                    return (str + '').replace(/(\r\n|\r|\n)/g, '<br>');
                }

                $(document).on('click', '.atender', function() {
                    // Captura o ID do ticket do link/botão clicado (que tem data-id)
                    const ticketId = $(this).data('id');
                    const statusTicket = $(this).data('status-ticket');
                    const data_solicitacao = $(this).data('data_solicitacao');
                    const numero_ticket = $(this).data('numero_ticket');
                    const user_id_solicitante = $(this).data('user_id_solicitante');
                    const empresa_id = $(this).data('empresa_id');
                    const tipo_servico_id = $(this).data('tipo_servico_id');
                    const descricao_servico = $(this).data('descricao_servico');
                    const observacoes = $(this).data('observacoes');
                    const statusClass = $(this).data('status-class');
                    // Aplica o nl2br e usa .html() para renderizar as tags <strong> e <br>
                    const historicoFormatado = nl2br(observacoes ?? 'Sem Histórico.');

                    $('#resolver_observacoesAnterioresInput').val(observacoes ?? '');

                    if (!observacoes || observacoes == '') {
                        console.log('passou aqui 1');
                        $('#resolver_observacoesAnteriores').html('Sem Histórico de devolução.');
                    } else {
                        console.log('passou aqui 2');
                        $('#resolver_observacoesAnteriores').html(historicoFormatado);
                    }

                    // Campos de Texto/Display (Para tags como <span>, <div>, ou <input> readonly)
                    $('#resolver_data_solicitacao').text(data_solicitacao);
                    $('#resolver_numero_ticket').text(numero_ticket);
                    $('#resolver_user_id_solicitante').text(user_id_solicitante); // Se for o nome do usuário
                    $('#resolver_descricao_servico').text(descricao_servico);
                    $('#resolver_empresa_id').text(empresa_id);
                    $('#resolver_tipo_servico_id').text(tipo_servico_id);
                    $('#resolver_statusTicket').text(statusTicket);

                    // 1. Busca o botão "Atender" dentro do modal
                    function setupModalByStatus(statusTicket) {
                        // 1. Busca os botões dentro do modal
                        const buttonAtender = $('#ResolverBtnAtender');
                        const buttonEncerrar = $('#ResolverBtnEncerrar');
                        const buttonDevolver = $('#ResolverBtnDevolver');
                        const observacaoField = $('#resolver_observacao');
                        const observacaoAnteriores = $('#resolver_observacoesAnteriores');

                        console.log('obsAnteriores', observacaoAnteriores);

                        // 2. RESET GERAL: Define o estado padrão (tudo visível, editável e desabilitado por padrão)
                        // Isso garante que você só precisa definir as exceções abaixo.
                        buttonAtender.removeClass('d-none btn-secondary').addClass('btn-success');
                        buttonEncerrar.removeClass('d-none');
                        buttonDevolver.removeClass('d-none');

                        // Desabilita todos por padrão, exceto se o status for 'Aberto' ou 'Em Andamento'
                        buttonAtender.prop('disabled', true);
                        buttonEncerrar.prop('disabled', false);
                        buttonDevolver.prop('disabled', false);

                        observacaoField.addClass('d-none');
                        observacaoAnteriores.prop('disabled', false).prop('readonly', false);

                        // 3. Lógica condicional (Estado de 'Aberto' é o mais comum para visibilidade)
                        switch (statusTicket) {
                            case 'Aberto':
                                // BOTÕES: Apenas Atender é importante
                                buttonAtender.prop('disabled', false);
                                buttonEncerrar.addClass('d-none');
                                buttonDevolver.addClass('d-none');

                                // CAMPO: Desabilitado para edição (somente leitura)
                                observacaoField.addClass('d-none');
                                observacaoAnteriores.prop('disabled', true).prop('readonly', true);

                                // CAMPO: Editável (padrão)
                                break;

                            case 'Em Andamento':
                                // BOTÕES: 'Atender' some, 'Encerrar' e 'Devolver' aparecem
                                buttonAtender.addClass('d-none');
                                // buttonEncerrar e buttonDevolver já estão visíveis (padrão)

                                // CAMPO: Desabilitado para edição (somente leitura)
                                observacaoField.removeClass('d-none');
                                observacaoAnteriores.prop('disabled', true).prop('readonly', true);

                                // CAMPO: Editável (padrão)
                                break;

                            case 'Pendente':
                                // BOTÕES: 'Devolver' visível, outros ocultos
                                buttonEncerrar.addClass('d-none');
                                buttonAtender.prop('disabled', false);

                                // CAMPO: Desabilitado para edição (somente leitura)
                                observacaoField.removeClass('d-none');
                                observacaoAnteriores.prop('disabled', true).prop('readonly', true);

                                // CAMPO: Editável (padrão)
                                break;

                            case 'Concluído':
                            case 'Devolvido': // Agrupa lógicas idênticas
                                // BOTÕES: Todos ocultos
                                buttonAtender.addClass('d-none');
                                buttonEncerrar.addClass('d-none');
                                buttonDevolver.addClass('d-none');

                                // CAMPO: Desabilitado para edição (somente leitura)
                                observacaoAnteriores.prop('disabled', true).prop('readonly', true);
                                break;

                            default:
                                // Caso padrão (opcional, se houver outros status)
                                // Esconde todos os botões por segurança
                                buttonAtender.addClass('d-none');
                                buttonEncerrar.addClass('d-none');
                                buttonDevolver.addClass('d-none');
                                observacaoField.removeClass('d-none');
                                observacaoAnteriores.prop('disabled', true).prop('readonly', true);
                                break;
                        }
                    }

                    // Cria o HTML do badge usando a classe que veio do PHP
                    const statusBadgeHtml = `<span class="badge ${statusClass}">${statusTicket}</span>`;

                    // Injeta o HTML formatado no contêiner do modal
                    $('#resolver_status_badge_container').html(statusBadgeHtml);

                    setupModalByStatus(statusTicket);


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
                $(document).on('click', '#ResolverBtnAtender', function(e) {
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

                                window.location.reload();

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


                // ===** DEVOLVER ATENDIMENTO **===

                // Use a base estática (sem o ID)
                const devolverAtendimentoBase = "{{ url('ticket/devolver') }}";

                // 1. Intercepta o clique no botão "Devolver"
                $(document).on('click', '#ResolverBtnDevolver', function(e) {
                    // Previne o comportamento padrão do botão submit (que fecharia o modal ou faria um submit de formulário)
                    e.preventDefault();

                    console.log('Clicou no botão Devolver');

                    const buttonDevolver = $(this);
                    const originalText = buttonDevolver.html(); // Salva o HTML original para restaurar em caso de erro

                    // Assumimos que o ID do ticket está armazenado em algum campo oculto ou em um atributo data
                    // AJUSTE ESSA LINHA: Você deve obter o ID do ticket do modal de alguma forma.
                    const ticketId = $('#resolver_ticket_id').val();

                    // Verifica se o ticketId foi encontrado
                    if (!ticketId) {
                        console.error('ID do ticket não encontrado. Abortando a requisição.');
                        return;
                    }

                    // 2. Substitui o placeholder na rota pelo ID real
                    const finalUrl = `${devolverAtendimentoBase}/${ticketId}`;
                    console.log('finalUrl:', finalUrl);

                    // Muda o texto do botão e desabilita temporariamente
                    buttonDevolver.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...'
                    );

                    // 3. Envia a requisição AJAX para o Laravel
                    $.ajax({
                        url: finalUrl,
                        method: 'POST', // Use POST ou PUT/PATCH, dependendo da sua rota
                        data: {
                            _token: '{{ csrf_token() }}', // Necessário para proteção CSRF no Laravel
                            // Você pode adicionar outros dados se necessário
                            observacoes: $('#resolver_nova_observacao').val(),
                            observacoesAnteriores: $('#resolver_observacoesAnterioresInput').val(),
                        },
                        success: function(response) {
                            // A rota deve retornar status 200 e, idealmente, um JSON de sucesso
                            if (response.status === 200 || response.success === true) {

                                // 4. Sucesso: Altera o botão para "Em Andamento" e bloqueia
                                buttonDevolver.removeClass('btn-success').addClass('btn-secondary');
                                buttonDevolver.html(
                                    '<i class="bi bi-person-fill-gear"></i> Em Andamento');
                                buttonDevolver.prop('disabled', true); // Mantém o botão bloqueado

                                // Opcional: Mostra uma notificação de sucesso
                                console.log('Atendimento aceito com sucesso!');

                                window.location.reload();

                            } else {
                                // Erro: Restaurar o botão original e mostrar mensagem
                                console.error('Erro ao aceitar atendimento:', response.message ||
                                    'Resposta inválida do servidor.');
                                buttonDevolver.prop('disabled', false).html(originalText);
                                // Opcional: Mostrar erro na tela
                                alert('Erro: ' + (response.message || 'Falha na operação.'));
                            }
                        },
                        error: function(xhr, status, error) {
                            // Erro de rede ou erro HTTP (4xx, 5xx)
                            console.error("AJAX Error: ", error);

                            // Restaurar o botão original
                            buttonDevolver.prop('disabled', false).html(originalText);
                            alert('Erro na comunicação com o servidor. Tente novamente.');
                        }
                    });
                });

                // ===** ENCERRAR ATENDIMENTO **===

                const encerrarAtendimentoBase = "{{ url('ticket/encerrar') }}";

                 // 1. Intercepta o clique no botão "Encerrar"
                $(document).on('click', '#ResolverBtnEncerrar', function(e) {
                    // Previne o comportamento padrão do botão submit (que fecharia o modal ou faria um submit de formulário)
                    e.preventDefault();

                    const buttonEncerrar = $(this);
                    const originalText = buttonEncerrar.html(); // Salva o HTML original para restaurar em caso de erro

                    // Assumimos que o ID do ticket está armazenado em algum campo oculto ou em um atributo data
                    // AJUSTE ESSA LINHA: Você deve obter o ID do ticket do modal de alguma forma.
                    const ticketId = $('#resolver_ticket_id').val();

                    // Verifica se o ticketId foi encontrado
                    if (!ticketId) {
                        console.error('ID do ticket não encontrado. Abortando a requisição.');
                        return;
                    }

                    // 2. Substitui o placeholder na rota pelo ID real
                    const finalUrl = `${encerrarAtendimentoBase}/${ticketId}`;

                    // Muda o texto do botão e desabilita temporariamente
                    buttonEncerrar.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Encerrando...'
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
                                buttonEncerrar.removeClass('btn-success').addClass('btn-secondary');
                                buttonEncerrar.html('<i class="bi bi-person-fill-gear"></i> Em Andamento');
                                buttonEncerrar.prop('disabled', true); // Mantém o botão bloqueado

                                window.location.reload();

                            } else {
                                // Erro: Restaurar o botão original e mostrar mensagem
                                console.error('Erro ao encerrar atendimento:', response.message ||
                                    'Resposta inválida do servidor.');
                                button.prop('disabled', false).html(originalText);
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

                // 1. Intercepta o Select Status Final
                // Remove todo o seu código AJAX. Apenas use o evento 'change' para submeter o formulário.

                $(document).ready(function() {

                    // Intercepta a mudança no Select Status Final
                    $(document).on('change', '#data_ticket', function() {

                        if ($(this).val() !== null) {
                            console.log('Data selecionada:', $(this).val());
                            // Armazena todos no select Status Final quando a data estiver preenchida
                            $('#select_statusFinal').val('Todos');
                            $('#search').val('');

                        }

                    });
                    // Intercepta a mudança no search
                    $(document).on('change', '#select_statusFinal', function() {

                        if ($(this).val() !== null) {
                            // Armazena todos no select Status Final quando a data estiver preenchida
                            $('#search').val('');
                            $('#data_ticket').val('');

                        }

                    });

                });

                // Lógica para alternar campos e texto ao CLICAR
                document.querySelectorAll('.dropdown-item[data-target]').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Esconde todos os campos de filtro
                        document.querySelectorAll('.filtro-campo').forEach(f => f.style.display =
                            'none');

                        // Mostra o campo correspondente
                        const campoId = this.getAttribute('data-target');
                        document.getElementById(campoId).style.display = 'block';

                        // 💡 NOVIDADE: Atualiza o texto do span
                        const filtroTextoSpan = document.getElementById('filtro-selecionado-texto');
                        const novoTexto = this.textContent.trim();
                        filtroTextoSpan.textContent = novoTexto; // Atualiza o texto.
                    });
                });

                // 3. NOVA LÓGICA: Estado inicial da visibilidade dos campos após o carregamento (Refresh)

                // Oculta todos os campos primeiro
                document.querySelectorAll('.filtro-campo').forEach(f => f.style.display = 'none');

                // Define o campo ativo com base na variável PHP lida na inicialização
                const filtroAtivoId = '{{ $filtroAtivo }}';

                if (filtroAtivoId && document.getElementById(filtroAtivoId)) {
                    document.getElementById(filtroAtivoId).style.display = 'block';
                }




            });
        </script>
    @endpush
</x-app-layout>

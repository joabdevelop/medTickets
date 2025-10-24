<x-app-layout title="Solicita Serviço">

    <body>
        <section class="container-section">
            <div class="container-list">
                <h1>Solicitações de Serviços</h1>

                <form method="GET" action="{{ route('solicitaServico.index') }}" class="input-group w-25">

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
                            <th>Solicitante</th>
                            <th>Executante</th>
                            <th>Status</th>
                            <th>Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($solicitaServicos as $solicitaServico)
                            <tr>
                                <td>{{ $solicitaServico->numero_ticket }}</td>
                                <td>{{ $solicitaServico->created_at->format('d/m/Y') }}</td>
                                <td>{{ $solicitaServico->tipo_servico->nome_servico }}</td>
                                <td>{{ $solicitaServico->user_solicitante->nome }}</td>
                                <td>{{ $solicitaServico->user_executante->nome ?? 'Na fila de espera' }}</td>
                                <td>
                                    @php
                                        // 1. Converte a string do banco de dados para o objeto Enum
                                        // Use tryFrom() para evitar erro se a string for inválida
                                        $statusEnum = \App\Enums\StatusTickets::tryFrom($solicitaServico->status_final);
                                    @endphp

                                    @if ($statusEnum)
                                        <span class="badge {{ $statusEnum->getBootstrapClass() }}">
                                            {{ $statusEnum->value }}
                                        </span>
                                    @else
                                        {{ $solicitaServico->status_final }} {{-- Exibe como texto simples se a conversão falhar --}}
                                    @endif
                                </td>
                                <td>

                                    <!-- Action Buttons -->

                                    <div class="btn-group btn-group-sm">
                                        <!-- Botão Alterar -->
                                        <a href="#" class="update" data-id="{{ $solicitaServico->id }}"
                                            data-bs-toggle="modal" data-user-id="{{ Auth::user()->id }}"
                                            data-user-departamento="{{ Auth::user()->profissional?->departamento?->sigla_depto }}"
                                            data-update_numero_ticket="{{ $solicitaServico->numero_ticket }}"
                                            data-update_user_departamento="{{ $solicitaServico->user_departamento }}"
                                            data-update_user_id="{{ $solicitaServico->user_id }}"
                                            data-update_data_solicitacao="{{ $solicitaServico->created_at }}"
                                            data-update_empresa_id="{{ $solicitaServico->empresa_id }}"
                                            data-update_tipo_servico_id="{{ $solicitaServico->tipo_servico_id }}"
                                            data-update_descricao_servico="{{ $solicitaServico->descricao_servico }}"
                                            data-update_status_final="{{ $solicitaServico->status_final }}"
                                            data-update_observacoes="{{ $solicitaServico->observacoes }}"
                                            data-bs-target="#updateSolicitaServicoModal">
                                            <i class="material-icons " data-bs-toggle="tooltip"
                                                title="Alterar">&#xE254;</i>
                                        </a>
                                    </div>

                                    @if ($solicitaServico->status_final == 'Aberto')
                                        <a href="#" class="delete" data-id="{{ $solicitaServico->id }}"
                                            data-numero-ticket="{{ $solicitaServico->numero_ticket }}"
                                            data-bs-toggle="modal" data-bs-target="#deleteSolicitaServicoModal">
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
                    {{ $solicitaServicos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
        <!-- Modals -->
        @include('solicitaServico.createModal')
        @include('solicitaServico.updateModal')
        @include('solicitaServico.deleteModal')
    </body>

    @push('scripts')
        <script>
            // Convertendo o array $tiposServicos em JSON
            // Sera utilizado pela função getTiposServicos
            const servicos = @json($tiposServicos) || [];

            document.addEventListener('DOMContentLoaded', function() {

                // --------------------------------------------------------------------------------
                // Lógica principal de CLIQUE nos botões de AÇÃO (Create e Update)
                // --------------------------------------------------------------------------------
                document.body.addEventListener('click', function(e) {

                    // 1. Encontra todos os botões que abrem o create modal
                    const createButton = e.target.closest('.create');

                    if (createButton) {
                        e.preventDefault();

                        // 1. Coleta os valores dos atributos data-*
                        const userId = createButton.getAttribute('data-user-id');
                        const userDepartamento = createButton.getAttribute('data-user-departamento');

                        // 2. Preenche os campos de formulário (substituindo .val())
                        const createUserIdInput = document.getElementById('create_user_id');
                        const createUserDepartamentoInput = document.getElementById('create_user_departamento');

                        if (createUserIdInput) {
                            createUserIdInput.value = userId;
                        }
                        if (createUserDepartamentoInput) {
                            createUserDepartamentoInput.value = userDepartamento;
                        }
                    }

                    // 2. Encontra todos os botões que abrem o update modal
                    const updateButton = e.target.closest('.update');

                    if (updateButton) {
                        e.preventDefault();

                        // 1. Coleta os valores dos atributos data-*
                        const userId = updateButton.getAttribute('data-id');
                        const userDepartamento = updateButton.getAttribute('data-user-departamento');
                        const dataSolicitacao = updateButton.getAttribute('data-update_data_solicitacao');
                        const empresaId = updateButton.getAttribute('data-update_empresa_id');
                        const tipoServicoId = updateButton.getAttribute('data-update_tipo_servico_id');
                        const descricaoServico = updateButton.getAttribute('data-update_descricao_servico');
                        const statusFinal = updateButton.getAttribute('data-update_status_final');
                        const numeroTicket = updateButton.getAttribute('data-update_numero_ticket');
                        const observacoes = updateButton.getAttribute('data-update_observacoes');

                        // 2. Preenche os campos de formulário (substituindo .val())
                        document.getElementById('update_user_id').value = userId;
                        document.getElementById('update_user_departamento').value = userDepartamento;
                        document.getElementById('update_empresa_id').value = empresaId;

                        document.getElementById('update_tipo_servico_id').value = tipoServicoId;
                        document.getElementById('update_descricao_servico').value = descricaoServico;

                        const descricaoServicoInput = getLabelDescricao(tipoServicoId);
                        const labelDescricaoServico = document.querySelector('#update_label_descricao_servico');
                        labelDescricaoServico.textContent = descricaoServicoInput;

                        document.getElementById('update_status_final_outros').textContent = statusFinal;
                        document.getElementById('update_status_final_concluido').textContent = statusFinal;

                        document.getElementById('update_numero_ticket').textContent = numeroTicket;
                        document.getElementById('update_numero_ticket_outros').textContent = numeroTicket;
                        document.getElementById('update_numero_ticket_concluido').textContent = numeroTicket;

                        document.getElementById('update_observacoes').textContent = observacoes;

                        if (dataSolicitacao) {
                            let dataFormatada = dataSolicitacao.split(' ')[0];

                            // Se vier no formato DD-MM-YYYY, inverte
                            if (dataFormatada.match(/^\d{2}-\d{2}-\d{4}$/)) {
                                const [dia, mes, ano] = dataFormatada.split('-');
                                dataFormatada = `${ano}-${mes}-${dia}`;
                            }

                            document.getElementById('update_data_solicitacao').value = dataFormatada;
                        }
                        // Atualizar action do form dinamicamente
                        const form = document.getElementById('updateSolicitaServicoForm');
                        if (form) {
                            form.action = '{{ route('solicitaServico.update', ':id') }}'.replace(':id',
                                userId);
                        }

                        const modalBodyAberto = document.getElementById('ModalBodyAberto');
                        const modalBodyDevolvido = document.getElementById('ModalBodyDevolvido');
                        const modalBodyStatusConcluido = document.getElementById('ModalBodyStatusConcluido');
                        const modalBodyButton = document.getElementById('ModalBodyButton');
                        const modalBodyStatusOutros = document.getElementById('ModalBodyStatusOutros');

                        // Esconde tudo
                        if (modalBodyAberto) modalBodyAberto.style.display = 'none';
                        if (modalBodyDevolvido) modalBodyDevolvido.style.display = 'none';
                        if (modalBodyStatusConcluido) modalBodyStatusConcluido.style.display = 'none';
                        if (modalBodyButton) modalBodyButton.style.display = 'none';
                        if (modalBodyStatusOutros) modalBodyStatusOutros.style.display = 'none';

                        // Verifica do status final
                        if (statusFinal === 'Aberto') {
                            if (modalBodyAberto) modalBodyAberto.style.display = 'block';
                            if (modalBodyButton) modalBodyButton.style.display = 'block';
                        } else if (statusFinal === 'Devolvido') {
                            if (modalBodyAberto) modalBodyAberto.style.display = 'block';
                            if (modalBodyDevolvido) modalBodyDevolvido.style.display = 'block';
                            if (modalBodyButton) modalBodyButton.style.display = 'block';
                        } else if (statusFinal === 'Concluído') {
                            if (modalBodyStatusConcluido) modalBodyStatusConcluido.style.display = 'block';
                        } else {
                            if (modalBodyStatusOutros) modalBodyStatusOutros.style.display = 'block';
                            if (modalBodyButton) modalBodyButton.style.display = 'none';
                        }
                    }

                    // A LÓGICA DO DELETE FOI MOVIDA PARA FORA DESTE HANDLER DE CLIQUE
                    // POIS O BOOTSTRAP JÁ DISPARA O MODAL VIA DATA-ATTRIBUTES.
                    // Isso evita anexar múltiplos listeners.

                }); // Fim do document.body.addEventListener('click', ...)


                // --------------------------------------------------------------------------------
                // Lógica dedicada ao Modal de Exclusão (DELETE)
                // Anexa o listener de evento show.bs.modal APENAS UMA VEZ.
                // --------------------------------------------------------------------------------
                const deleteModal = document.getElementById('deleteSolicitaServicoModal');



                if (deleteModal) {
                    // Escuta o evento show.bs.modal que é disparado pelo Bootstrap
                    deleteModal.addEventListener('show.bs.modal', function(event) {
                        // Pega o botão que acionou o modal (o <a> com a classe .delete)
                        const button = event.relatedTarget;

                        // Coleta os atributos data-* do botão
                        const servicoId = button.getAttribute('data-id');
                        const servicoTicket = button.getAttribute('data-numero-ticket');

                        // Referência ao formulário de exclusão dentro do modal
                        const deleteForm = deleteModal.querySelector('#deleteSolicitaServicoForm');

                        // Referência ao elemento onde o número do ticket será exibido na mensagem
                        // Usei um ID mais seguro, '#delete_ticket_display', mas mantive '#delete_numero_ticket'
                        // caso seja o ID do seu elemento de confirmação.
                        const ticketDisplayElement = deleteModal.querySelector('#delete_numero_ticket');

                        // 1. Atualiza o texto de confirmação com o número do ticket
                        if (ticketDisplayElement) {
                            ticketDisplayElement.textContent = servicoTicket;
                            ticketDisplayElement.style.fontWeight = 'bold'; // Mantive o estilo
                        }

                        // 2. Atualiza a action do formulário para a rota de exclusão correta
                        if (deleteForm) {
                            deleteForm.action = '{{ route('solicitaServico.destroy', ':id') }}'.replace(':id',
                                servicoId);
                        }
                    });
                }
                // Fim da Lógica de Exclusão



                // ==> Função para atualizar o texto da label (UPDATE) <== \\
                const selectServicoUpdate = document.getElementById('update_tipo_servico_id');
                const labelDescricaoUpdate = document.getElementById('update_label_descricao_servico');

                // Função para atualizar o texto da label
                function updateLabelDescricao() {
                    if (!selectServicoUpdate || !labelDescricaoUpdate) return;

                    // Pega a opção selecionada no momento
                    const selectedOption = selectServicoUpdate.options[selectServicoUpdate.selectedIndex];

                    // Verifica se a opção selecionada tem um ID válido (não é a opção "Selecione")
                    if (selectedOption && selectedOption.value) {
                        // Pega o valor do atributo data-titulo_nome
                        const tituloNome = selectedOption.getAttribute('data-titulo_nome');

                        // Atualiza o texto da label com o título
                        labelDescricaoUpdate.textContent = tituloNome || 'Título não encontrado.';
                    } else {
                        // Se nenhuma opção válida estiver selecionada, usa a mensagem padrão
                        labelDescricaoUpdate.textContent = 'Aguardando a seleção...';
                    }
                }

                // 1. Adiciona o listener para o evento 'change'
                if (selectServicoUpdate) {
                    selectServicoUpdate.addEventListener('change', updateLabelDescricao);
                }

                // 2. Chama a função na inicialização para lidar com o caso onde já há um 'old' value selecionado
                updateLabelDescricao();


                // Função auxiliar para o update modal
                function getLabelDescricao(servicoId) {
                    const id = Number(servicoId);
                    const servico = servicos.find(s => Number(s.id) === id);
                    return servico ? servico.titulo_nome : 'Título não encontrado.';
                }

                // ==> Função para atualizar o texto da label (CREATE) <== \\
                const selectServico = document.getElementById('create_tipo_servico_id');
                const labelDescricao = document.getElementById('label_descricao_servico');

                // Função para atualizar o texto da label
                function createLabelDescricao() {
                    if (!selectServico || !labelDescricao) return;

                    // Pega a opção selecionada no momento
                    const selectedOption = selectServico.options[selectServico.selectedIndex];

                    // Verifica se a opção selecionada tem um ID válido (não é a opção "Selecione")
                    if (selectedOption && selectedOption.value) {
                        // Pega o valor do atributo data-titulo_nome
                        const tituloNome = selectedOption.getAttribute('data-titulo_nome');

                        // Atualiza o texto da label com o título
                        labelDescricao.textContent = tituloNome || 'Título não encontrado.';
                    } else {
                        // Se nenhuma opção válida estiver selecionada, usa a mensagem padrão
                        labelDescricao.textContent = 'Aguardando a seleção...';
                    }
                }

                // 1. Adiciona o listener para o evento 'change'
                if (selectServico) {
                    selectServico.addEventListener('change', createLabelDescricao);
                }

                // 2. Chama a função na inicialização para lidar com o caso onde já há um 'old' value selecionado
                createLabelDescricao();



            });
        </script>
    @endpush
</x-app-layout>

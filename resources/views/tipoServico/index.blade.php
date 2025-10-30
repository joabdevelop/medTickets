<x-app-layout title="Tipos de Serviço">
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @endpush


    <!-- List Section -->
    <section class="container-section">
        <div class="container-list">
            <h1>Serviços</h1>

            <form method="GET" action="{{ route('tipo_servico.index') }}" class="input-group w-25">

                <input type="search" name="search" id="search" value="{{ old('search') ?? request('search') }}"
                    class="form-control rounded-start" placeholder="Buscar..." aria-label="Buscar">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">search</i>
                </button>
            </form>

            <!-- Button trigger modal -->

            <button type="button" class=" btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#createTipoServicoModal" title="Incluir">
                Adicionar
                <i class="bi bi-folder-plus"></i>
            </button>
        </div>
    </section>
    <!-- Table Section -->
    <section class="table-section ">
        <div class="table-list">

            <!-- Alertas de sucesso ou erro -->
            @include('components.alertas')

            <table class="table table-hover cursor-pointer table-responsive">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nome do Serviço</th>
                        <th>Depto Executante</th>
                        <th>Prioridade</th>
                        <th>SLA</th>
                        <th>Quem Solicita o Serviço</th>

                        <!-- Action Buttons Modal -->
                        <th>Alterar</th>
                        <th>Ativar/inativar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tipo_servicos as $tipo_servico)
                        <tr>
                            <td>
                                @if ($tipo_servico->servico_ativo)
                                    <h6><span class="badge rounded-pill text-bg-success">Ativo</span></h6>
                                @else
                                    <h6><span class="badge rounded-pill text-bg-danger">Inativo</span></h6>
                                @endif
                            </td>
                            <td>{{ $tipo_servico->nome_servico }}</td>
                            <td>{{ $tipo_servico->departamento->nome }}</td>
                            <td>{{ $tipo_servico->prioridade->label() }}</td>
                            <td> {{ $tipo_servico->sla }} horas</td>
                            <td>
                                {{ $tipo_servico->quem_solicita->label() }}
                            </td>
                            <td>
                                <!-- Action Buttons -->
                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Alterar -->
                                    <a href="#" class="edit" data-id="{{ $tipo_servico->id }}"
                                        data-update_nome_servico="{{ $tipo_servico->nome_servico }}"
                                        data-update_titulo_nome="{{ $tipo_servico->titulo_nome }}"
                                        data-update_prioridade="{{ $tipo_servico->prioridade }}"
                                        data-update_sla="{{ $tipo_servico->sla }}"
                                        data-update_quem_solicita="{{ $tipo_servico->quem_solicita }}"
                                        data-update_executante_departamento_id="{{ $tipo_servico->departamento->nome }}"
                                        data-update_dados_add="{{ $tipo_servico->dados_add }}"
                                        data-update_servico_ativo="{{ $tipo_servico->servico_ativo }}"
                                        data-bs-toggle="modal" data-bs-target="#updateTipoServicoModal">
                                        <i class="material-icons" data-bs-toggle="tooltip" title="Alterar">&#xE254;</i>
                                    </a>
                                </div>

                            </td>
                            <td class="text-center">
                                <div class="form-switch">
                                    <!-- Botão Ativar/Inativar -->
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        data-id="{{ $tipo_servico->id }}"
                                        data-nome_servico="{{ $tipo_servico->nome_servico }}"
                                        data-status="{{ $tipo_servico->servico_ativo ? 1 : 0 }}" data-bs-toggle="modal"
                                        data-bs-target="#alterarServicoAtivoModal" role="switch"
                                        @if ($tipo_servico->servico_ativo) checked @endif>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <td colspan="8" class="text-center">Nenhum grupo encontrado.</td>
                    @endforelse
                </tbody>
            </table>
            <div class="clearfix">
                {{ $tipo_servicos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
    <!-- Modals -->
    @include('tipoServico.createModal')
    @include('tipoServico.updateModal')
    @include('tipoServico.alterarServicoAtivoModal')


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Foco automático nos modais
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.addEventListener('shown.bs.modal', event => {
                        const trigger = event.relatedTarget;
                        const focusSelector = trigger?.getAttribute('data-focus');
                        if (focusSelector) modal.querySelector(focusSelector)?.focus();
                    });
                });

                // Função auxiliar para encontrar o valor (ID) de uma opção pelo seu texto (nome)
                function findIdByText(selectElement, textValue) {
                    if (!selectElement || !textValue) return null;

                    // Itera sobre todas as opções
                    for (let i = 0; i < selectElement.options.length; i++) {
                        // Compara o texto da opção (sem espaços extras) com o texto que veio do botão
                        if (selectElement.options[i].text.trim() === textValue.trim()) {
                            // Retorna o valor (ID) da opção
                            return selectElement.options[i].value;
                        }
                    }
                    return null;
                }

                // Modal UPDATE
                const updateTipoServicoModal = document.getElementById('updateTipoServicoModal');
                if (!updateTipoServicoModal) return;
                if (updateTipoServicoModal) {
                    updateTipoServicoModal.addEventListener('show.bs.modal', event => {
                        const editButton = event.relatedTarget; // O botão que triggerou o modal
                        if (!editButton) return; // Safety check

                        const id = editButton.getAttribute('data-id');
                        const nome = editButton.getAttribute('data-update_nome_servico');
                        const titulo_nome = editButton.getAttribute('data-update_titulo_nome');
                        const prioridade = editButton.getAttribute('data-update_prioridade');
                        const sla = editButton.getAttribute('data-update_sla');
                        const quem_solicita = editButton.getAttribute('data-update_quem_solicita');
                        const executante_departamento_id_attr = editButton.getAttribute(
                            'data-update_executante_departamento_id');
                        const dados_add = editButton.getAttribute('data-update_dados_add');
                        const servico_ativo = editButton.getAttribute(
                        'data-update_servico_ativo'); // Valor booleano

                        // Preencher os campos
                        updateTipoServicoModal.querySelector('#id').value = id || '';
                        updateTipoServicoModal.querySelector('#update_nome_servico').value = nome || '';
                        updateTipoServicoModal.querySelector('#update_titulo_nome').value = titulo_nome || '';
                        updateTipoServicoModal.querySelector('#update_prioridade').value = prioridade || '';
                        updateTipoServicoModal.querySelector('#update_sla').value = sla || '';
                        updateTipoServicoModal.querySelector('#update_quem_solicita').value = quem_solicita ||
                            '';
                        updateTipoServicoModal.querySelector('#update_dados_add').value = dados_add || '';
                        //Logica para o valor booleano
                        const servico_ativo_convertido = servico_ativo === '1' || servico_ativo === 1;

                        const servico_ativo_selecionado = updateTipoServicoModal.querySelector(
                            '#update_servico_ativo');
                        // Verifica se o checkbox foi selecionado
                        if (servico_ativo_selecionado) {
                            // Define o estado do checkbox
                            servico_ativo_selecionado.checked = servico_ativo_convertido;
                        }

                        //CONSTANTE DE DEPARTAMENTO PARA BUSCAR O ID
                        const selectExecutante = updateTipoServicoModal.querySelector(
                            '#update_executante_departamento_id');

                        // Se o atributo lido for um número (ID), usamos ele diretamente.
                        // Se for uma string (NOME, como "Relacionamento"), procuramos o ID correspondente.
                        let finalExecutanteId = executante_departamento_id_attr;

                        // Se o atributo lido for uma string (NOME, como "Relacionamento"), procuramos o ID correspondente.
                        if (isNaN(parseInt(executante_departamento_id_attr)) ||
                            typeof executante_departamento_id_attr === 'string' && isNaN(
                                executante_departamento_id_attr)) {
                            // Tenta encontrar o ID correspondente ao nome do departamento (ex: "Relacionamento" -> 1)
                            finalExecutanteId = findIdByText(selectExecutante, executante_departamento_id_attr);
                        }

                        // Atribui o ID correto ao select
                        selectExecutante.value = finalExecutanteId || '';

                        // Atualizar action do form dinamicamente
                        const form = document.getElementById('updateTipoServicoForm');
                        if (form) {
                            form.action = '{{ route('tipo_servico.update', ':id') }}'.replace(':id', id);
                        }



                    });
                }

                // Modal ALTERAR SERVICO ATIVO
                const toggleServicoAtivoModal = document.getElementById('alterarServicoAtivoModal');
                if (!toggleServicoAtivoModal) return;
                document.body.addEventListener('change', function(event) {

                    if (event.target && event.target.matches('.status-toggle')) {

                        const toggleCheckbox = event.target;
                        event.preventDefault();
                        toggleCheckbox.checked = !toggleCheckbox.checked;

                        const id = toggleCheckbox.dataset.id;
                        const nomeServico = toggleCheckbox.dataset.nome_servico;
                        const form = toggleServicoAtivoModal.querySelector('form');
                        console.log('foi passado o form', form);
                        const nomeServicoSpan = toggleServicoAtivoModal.querySelector('#nome_servico');

                        // Verifica se o elemento foi encontrado antes de tentar preenchê-lo.
                        if (nomeServicoSpan) {
                            nomeServicoSpan.innerHTML = nomeServico || 'Não informado';
                        }

                        if (form) {
                            const actionUrl = `/tipo_servico/${id}/toggle`;
                            form.action = actionUrl;

                            toggleServicoAtivoModal.dataset.checkboxToRevertId = toggleCheckbox.id ||
                                `toggle-temp-${id}`;
                            if (!toggleCheckbox.id) {
                                toggleCheckbox.id = toggleServicoAtivoModal.dataset.checkboxToRevertId;
                            }
                        }
                    }
                });









            });
        </script>
    @endpush

</x-app-layout>

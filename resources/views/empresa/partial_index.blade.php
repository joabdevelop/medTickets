<section class="container-section">
    <x-list-header title="Lista de Empresas" route="{{ route('empresa.index') }}" placeholder="Buscar..."
        modal="createEmpresaModal" icon="bi bi-plus-lg" :rounded="false" />

</section>
<section class="table-section">
    <!-- Alertas de sucesso ou erro -->
    @include('components.alertas')
    <div class="table-list table-responsive">

        <!-- O ELEMENTO TOOLTIP QUE SERÁ MANIPULADO PELO JS -->
        <div id="status-tooltip" class="custom-tooltip"></div>

        <table class="table cursor-pointer table-borderless table-hover align-middle caption-top">
            <thead>
                <tr>
                    <th>Status Produto/Preço</th>
                    <th>Grupo</th>
                    <th>Tipo de Cliente</th>
                    <th>Nome da Empresa/Unidade</th>
                    <th>CPF/CNPJ</th>
                    <th>Relacionamento</th>
                    <th>Modalidade</th>
                    <th>Data de Cadastro</th>
                    <!-- Action Buttons Modal -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-empresas">
                @forelse ($empresas as $empresa)
                    <tr data-status-bloqueio="{{ $empresa->bloqueio_status_financ == 1 ? 'ativo' : 'inativo' }}"
                        class="{{ $empresa->bloqueio_status_financ == 1 ? 'bloqueio-inativo' : '' }}">

                        <td>
                            @if ($empresa->status_produto_preco)
                                <span class="badge bg-success p-2 text-uppercase h6-font-size">Ativo</span>
                            @else
                                <span class="badge bg-danger p-2 text-uppercase h6-font-size">Inativo</span>
                            @endif
                        </td>

                        <td>{{ $empresa->grupo->nome_grupo }}</td>
                        <td>
                            @if ($empresa->data_contrato >= now()->subYear())
                                NOVO
                            @else
                                ANTIGO
                            @endif
                        </td>
                        <td>{{ $empresa->nome_fantasia }}</td>
                        <td>{{ $empresa->codigo_fiscal_formatado }}</td>
                        <td>{{ $empresa->grupo->profissional->nome }}</td>
                        <td>{{ $empresa->modalidade }}</td>
                        <td>{{ $empresa->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <!-- Botão Alterar -->
                                <!-- Dentro do <td> de ações -->
                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Editar (agora abre modal diretamente) -->
                                    <button type="button" class="btn btn-outline-success edit"
                                          data-bs-toggle="modal" data-bs-target="#updateEmpresaModal"
                                        data-id="{{ $empresa->id }}"
                                        data-grupo-empresarial="{{ $empresa->id_grupo }}"
                                        data-data-contrato="{{ $empresa->data_contrato ? $empresa->data_contrato->format('Y-m-d') : '' }}"
                                        data-nome-fantasia="{{ $empresa->nome_fantasia }}"
                                        data-razao-social="{{ $empresa->razao_social }}"
                                        data-codigo-fiscal="{{ $empresa->codigo_fiscal }}"
                                        data-email-contato="{{ $empresa->email_contato }}"
                                        data-grupo-classificacao="{{ $empresa->grupo_classificacao }}"
                                        data-modalidade="{{ $empresa->modalidade }}"
                                        data-fif-status="{{ $empresa->FIF_status }}"
                                        data-fif-data-liberacao="{{ $empresa->FIF_data_liberacao ? $empresa->FIF_data_liberacao->format('Y-m-d') : '' }}"
                                        data-ultima-renovacao-tipo="{{ $empresa->ultima_renovacao_tipo }}"
                                        data-ultima-renovacao-contrato="{{ $empresa->ultima_renovacao ? $empresa->ultima_renovacao->format('Y-m-d') : '' }}"
                                        data-bloqueio-status-financ="{{ $empresa->bloqueio_status_financ ? 1 : 0 }}"
                                         title="Alterar Empresa"
                                        data-status-produto-preco="{{ $empresa->status_produto_preco ? 1 : 0 }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <!-- Botão Visualizar Dados -->
                                <button type="button" class="btn btn-outline-primary search visualizar-empresas"
                                    role="button" data-bs-toggle="modal"
                                    data-bs-target="#visualizarEmpresaModal"
                                    data-bs-relacionamento="{{ $empresa->grupo->profissional->nome }}"
                                    data-id="{{ $empresa->id }}"
                                    data-grupo-empresarial="{{ $empresa->grupo->nome_grupo }}"
                                    data-data-contrato="{{ $empresa->data_contrato ? $empresa->data_contrato->format('Y-m-d') : '' }}"
                                    data-nome-fantasia="{{ $empresa->nome_fantasia }}"
                                    data-razao-social="{{ $empresa->razao_social }}"
                                    data-codigo-fiscal="{{ $empresa->CodigoFiscalFormatado }}"
                                    data-email-contato="{{ $empresa->email_contato }}"
                                    data-grupo-classificacao="{{ $empresa->grupo_classificacao }}"
                                    data-modalidade="{{ $empresa->modalidade }}"
                                    data-fif-status="{{ $empresa->FIF_status }}"
                                    data-fif-data-liberacao="{{ $empresa->FIF_data_liberacao ? $empresa->FIF_data_liberacao->format('Y-m-d') : '' }}"
                                    data-ultima-renovacao-tipo="{{ $empresa->ultima_renovacao_tipo }}"
                                    data-ultima-renovacao-contrato="{{ $empresa->ultima_renovacao ? $empresa->ultima_renovacao->format('Y-m-d') : '' }}"
                                    data-bloqueio-status-financ="{{ $empresa->bloqueio_status_financ ? 1 : 0 }}"
                                     title="Visualizar Empresa"
                                    data-status-produto-preco="{{ $empresa->status_produto_preco ? 1 : 0 }}" >
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="8" class="text-center">Nenhuma empresa encontrada.</td>
                @endforelse
            </tbody>

        </table>
        <div class="clearfix">
            {{ $empresas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
<!-- Modals -->
@include('empresa.createEmpresaModal')
@include('empresa.updateEmpresaModal')
@include('empresa.visualisarDadosModal')

{{-- Scripts: convertidos do @push --}}
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

        // Modal UPDATE
        const updateEmpresaModal = document.getElementById('updateEmpresaModal');
        if (updateEmpresaModal) {
            updateEmpresaModal.addEventListener('show.bs.modal', event => {
                const editButton = event.relatedTarget; // O botão que triggerou o modal
                if (!editButton) return; // Safety check

                const id = editButton.getAttribute('data-id');
                const grupo_empresarial = editButton.getAttribute('data-grupo-empresarial');
                const data_contrato = editButton.getAttribute('data-data-contrato');
                const nome_fantasia = editButton.getAttribute('data-nome-fantasia');
                const razao_social = editButton.getAttribute('data-razao-social');
                const codigo_fiscal = editButton.getAttribute('data-codigo-fiscal');
                const email_contato = editButton.getAttribute('data-email-contato');
                const grupo_classificacao = editButton.getAttribute('data-grupo-classificacao');
                const modalidade = editButton.getAttribute('data-modalidade');
                const fif_status = editButton.getAttribute('data-fif-status');
                const FIF_data_liberacao = editButton.getAttribute('data-fif-data-liberacao');

                console.log('FIF_data_liberacao:', FIF_data_liberacao);
                const ultima_renovacao_tipo = editButton.getAttribute('data-ultima-renovacao-tipo');
                console.log('Ultima renovacao tipo:', ultima_renovacao_tipo);

                const ultima_renovacao_contrato = editButton.getAttribute(
                    'data-ultima-renovacao-contrato');
                const bloqueio_status_financ = editButton.getAttribute('data-bloqueio-status-financ');
                const status_produto_preco = editButton.getAttribute('data-status-produto-preco');

                // Preencher os campos
                updateEmpresaModal.querySelector('#grupo_empresarial_select').value =
                    grupo_empresarial || '';
                updateEmpresaModal.querySelector('#nome_fantasia').value = nome_fantasia || '';
                updateEmpresaModal.querySelector('#razao_social').value = razao_social || '';
                updateEmpresaModal.querySelector('#codigo_fiscal').value = codigo_fiscal || '';
                updateEmpresaModal.querySelector('#email_contato').value = email_contato || '';
                updateEmpresaModal.querySelector('#grupo_classificacao').value = grupo_classificacao ||
                    '';
                updateEmpresaModal.querySelector('#modalidade').value = modalidade || '';
                updateEmpresaModal.querySelector('#fif_status').value = fif_status || '';
                updateEmpresaModal.querySelector('#FIF_data_liberacao').value = FIF_data_liberacao ||
                    '';
                updateEmpresaModal.querySelector('#ultima_renovacao_tipo').value =
                    ultima_renovacao_tipo || '';
                updateEmpresaModal.querySelector('#ultima_renovacao_contrato').value =
                    ultima_renovacao_contrato || '';
                updateEmpresaModal.querySelector('#data_contrato').value = data_contrato || '';

                // Checkboxes: checked se 1/true/'1'
                const bloqueioCheckbox = updateEmpresaModal.querySelector('#bloqueio_status_financ');
                if (bloqueioCheckbox) bloqueioCheckbox.checked = bloqueio_status_financ == '1' ||
                    bloqueio_status_financ === 'true';

                const statusCheckbox = updateEmpresaModal.querySelector('#status_produto_preco');
                if (statusCheckbox) statusCheckbox.checked = status_produto_preco == '1' ||
                    status_produto_preco === 'true';

                // Atualizar action do form dinamicamente
                const form = document.getElementById('editForm');
                if (form) {
                    form.action = '{{ route('empresa.update', ':id') }}'.replace(':id', id);
                }

            });
        }

        // Modal VISUALIZAR
        const visualizarEmpresaModal = document.getElementById('visualizarEmpresaModal');
        if (visualizarEmpresaModal) {
            visualizarEmpresaModal.addEventListener('show.bs.modal', event => {
                const viewButton = event.relatedTarget; // O botão que triggerou o modal
                if (!viewButton) return; // Safety check

                const id = viewButton.getAttribute('data-id');
                const grupo_empresarial = viewButton.getAttribute('data-grupo-empresarial');
                const data_contrato = viewButton.getAttribute('data-data-contrato');
                const nome_fantasia = viewButton.getAttribute('data-nome-fantasia');
                const razao_social = viewButton.getAttribute('data-razao-social');
                const codigo_fiscal = viewButton.getAttribute('data-codigo-fiscal');
                const email_contato = viewButton.getAttribute('data-email-contato');
                const grupo_classificacao = viewButton.getAttribute('data-grupo-classificacao');
                const modalidade = viewButton.getAttribute('data-modalidade');
                const fif_status = viewButton.getAttribute('data-fif-status');
                const fif_data_liberacao = viewButton.getAttribute('data-fif-data-liberacao');
                const ultima_renovacao_tipo = viewButton.getAttribute('data-ultima-renovacao-tipo');
                const ultima_renovacao_contrato = viewButton.getAttribute(
                    'data-ultima-renovacao-contrato');
                const bloqueio_status_financ = viewButton.getAttribute('data-bloqueio-status-financ');
                const status_produto_preco = viewButton.getAttribute('data-status-produto-preco');
                const relacionamento = viewButton.getAttribute('data-bs-relacionamento');

                // Função helper pra setar texto com check de null
                function setText(selector, value) {
                    const element = visualizarEmpresaModal.querySelector(selector);
                    if (element) {
                        element.textContent = value || 'Não informado';
                    } else {
                        console.warn('Elemento não encontrado:', selector);
                    }
                }

                // Preencher os campos de visualização
                setText('#view_grupo_empresarial', grupo_empresarial || 'Não informado');
                setText('#view_data_contrato', data_contrato ? new Date(data_contrato)
                    .toLocaleDateString('pt-BR') : 'Não informado');
                setText('#view_nome_fantasia', nome_fantasia || 'Não informado');
                setText('#view_razao_social', razao_social || 'Não informado');
                setText('#view_codigo_fiscal', codigo_fiscal || 'Não informado');
                setText('#view_email_contato', email_contato || 'Não informado');
                setText('#view_grupo_classificacao', grupo_classificacao || 'Não informado');
                setText('#view_modalidade', modalidade || 'Não informado');
                setText('#view_fif_status', fif_status || 'Não informado');
                setText('#view_fif_data_liberacao', fif_data_liberacao ? new Date(fif_data_liberacao)
                    .toLocaleDateString('pt-BR') : 'Não informado');
                setText('#view_ultima_renovacao_tipo', ultima_renovacao_tipo || 'Não informado');
                setText('#view_ultima_renovacao_contrato', ultima_renovacao_contrato ? new Date(
                    ultima_renovacao_contrato).toLocaleDateString('pt-BR') : 'Não informado');
                setText('#view_relacionamento', relacionamento || 'Não informado');

                // Checkboxes como texto
                setText('#view_bloqueio_status_financ', bloqueio_status_financ == '1' ? 'Sim' : 'Não');
                setText('#view_status_produto_preco', status_produto_preco == '1' ? 'Sim' : 'Não');

                console.log('Modal de visualização populado para ID:', id);
            });
        }

        const tabela = document.getElementById('tabela-empresas');
        const tooltip = document.getElementById('status-tooltip');

        if (!tabela || !tooltip) return;

        // Adiciona listeners aos elementos que contêm o status (as linhas <tr>)
        const linhas = tabela.querySelectorAll('tr[data-status-bloqueio]');

        linhas.forEach(linha => {
            const status = linha.getAttribute('data-status-bloqueio'); // 'ativo' ou 'inativo'
            let statusText;
            let statusClass;

            if (status === 'ativo') {
                statusText = 'FINANCEIRO BLOQUEIODO';
                statusClass = 'ativo';
            } else {
                statusText = 'FINANCEIRO ATIVO';
                statusClass = 'inativo';
            }

            // --- Evento: Mouse Entra (Exibir Tooltip) ---
            linha.addEventListener('mouseenter', function(e) {
                // 1. Atualiza o conteúdo e a classe do tooltip
                tooltip.textContent = statusText;
                tooltip.className = 'custom-tooltip ' + statusClass;

                // 2. Calcula a posição (para que o tooltip apareça logo abaixo do cursor)
                // Usamos clientY e clientX do evento
                const x = e.clientX + 10;
                const y = e.clientY + 10;

                tooltip.style.left = `${x}px`;
                tooltip.style.top = `${y}px`;

                // 3. Torna o tooltip visível
                tooltip.style.opacity = 1;
            });

            // --- Evento: Mouse Move (Seguir o Cursor) ---
            linha.addEventListener('mousemove', function(e) {
                // Atualiza a posição constantemente
                tooltip.style.left = `${e.clientX + 10}px`;
                tooltip.style.top = `${e.clientY + 10}px`;
            });

            // --- Evento: Mouse Sai (Esconder Tooltip) ---
            linha.addEventListener('mouseleave', function() {
                // Oculta o tooltip
                tooltip.style.opacity = 0;
            });
        });

    });
</script>

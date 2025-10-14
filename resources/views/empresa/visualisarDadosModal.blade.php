<!-- Create Modal VISUALIZAR EMPRESA HTML -->
<div class="modal fade" id="visualizarEmpresaModal" tabindex="-1" role="dialog" aria-labelledby="visualizarEmpresaModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <div class="modal-header bg-may-green-t">
                <div class="col-md-6">
                    <h4 class="modal-title">Dados da Empresa</h4>
                </div>
                <div class="col-md-6">
                    <h1 id="message"></h1>
                </div>
            </div>

            <div class="modal-body  ">
                <!-- Conteúdo de visualização (sem form, só dados read-only) -->
                <div class="container">

                    <!-- Relacionamento -->
                    <div class="flex mb-2 gap-2 items-center">
                        <span class="fw-bold">Relacionamento:</span>
                        <span id="view_relacionamento" class="flex-1"></span>
                    </div>
                    
                    <div class="row form-cadastro  gap-3">

                        <div class="col">

                            <!-- Grupo -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Grupo: </b></span>
                                <span id="view_grupo_empresarial"></span>
                            </div>

                            <!-- Nome Fantasia e Razão Social -->

                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Nome De Fantasia:</b></span>
                                <span id="view_nome_fantasia"></span>
                            </div>

                            <!-- Código Fiscal -->

                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>CNPJ/CPF:</b></span>
                                <span id="view_codigo_fiscal"></span>
                            </div>

                            <!-- Classificação -->

                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Classificação:</b></span>
                                <span id="view_grupo_classificacao"></span>
                            </div>

                            <!-- FIF Status -->

                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>FIF Status:</b></span>
                                <span id="view_fif_status"></span>
                            </div>

                            <!-- Tipo Renovação -->

                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Tipo Renovação:</b></span>
                                <span id="view_ultima_renovacao_tipo"></span>
                            </div>

                            <!-- Checkboxes como texto -->
                            <!-- Status Produto/Preço está ativo? -->
                            <div class="flex gap-2 pb-3">
                                <b>Status Produto/Preço está ativo? </b>
                                <span id="view_status_produto_preco" class="flex-1"></span>
                            </div>

                        </div>

                        <div class="col">

                            <!-- Data do Contrato -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Data do Contrato: </b></span>
                                <span id="view_data_contrato"></span>
                            </div>

                            <!-- Razão Social -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Razão Social:</b></span>
                                <span id="view_razao_social"></span>
                            </div>

                            <!-- Email de Contato -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Email de Contato:</b></span>
                                <span id="view_email_contato"></span>
                            </div>

                            <!-- Modalidade -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Modalidade:</b></span>
                                <span id="view_modalidade"></span>
                            </div>

                            <!-- Data Liberação da FIF -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Data Liberação da FIF:</b></span>
                                <span id="view_fif_data_liberacao"></span>
                            </div>

                            <!-- Última Renovação -->
                            <div class="row mb-3 border-b-1 border-b-gray-300">
                                <span><b>Última Renovação:</b></span>
                                <span id="view_ultima_renovacao_contrato"></span>
                            </div>

                            <!-- Checkboxes como texto -->
                            <!-- Tem Bloqueio Financeiro? -->
                            <div class="flex gap-2 pb-3">
                                <b>Tem bloqueio Financeiro? </b>
                                <span id="view_bloqueio_status_financ" class="flex-1"></span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Fim do conteúdo de visualização -->
            <div class="modal-footer bg-may-green-b">

                <div class="flex justify-end">
                    <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal"  onclick="event.target.blur()">
                        Fechar
                    </button>
                </div>

            </div>
        </div>
    </div>
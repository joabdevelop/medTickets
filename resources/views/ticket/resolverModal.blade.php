<!-- resolver Modal RESOLVER TICKETS HTML -->
<div class="modal fade" id="resolverTicketsModal" tabindex="-1" role="dialog" aria-labelledby="resolverTicketsModal"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content ">

            <form name="resolverTicketsModal" id="resolverTicketsModalForm" method="POST" action="">
                @method('PUT')
                @csrf

                <!-- Cabeçalho do formulário -->
                <div class="modal-header bg-may-green-t">
                    <div class="row w-100 m-0 p-0 align-items-center">

                        <div class="col-12 col-md-6 d-flex  flex-column mb-md-0">

                            <div class="d-flex align-items-center">
                                <h4 class="modal-title fw-bolder mb-0 text-white">Solicitação</h4>
                            </div>

                            <div class="small ">
                                <span class="fw-bolder text-primary-emphasis">
                                    Aberto em:

                                </span>
                                <span id="resolver_data_solicitacao" class="text-white-50">29/10/2025</span>
                            </div>

                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center">

                            <div class="d-flex flex-column align-items-center ">
                                <span id="resolver_status_badge_container">
                                    <span class="badge bg-secondary">Aguardando JS</span>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Corpo do formulário aberto e concluido -->
                <div class="modal-body" id="ModalBodyAberto">

                    <!-- Coluna 1: Informações de Serviço -->
                    <div class="form-cadastro container-fluid p-0">

                        <!-- numero_ticket (Pode ser gerado automaticamente, mas deixo como read-only) -->
                        <input type="hidden" class="form-control" id="resolver_user_departamento"
                            name="resolver_user_departamento" />
                        <input type="hidden" class="form-control" id="resolver_ticket_id" name="resolver_ticket_id" />



                        <!-- Solicitante E data da solicitação -->
                        <div class="row w-100 align-items-center">

                            <!-- Numero do Ticket -->
                            <div class="col-md-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Numero do Ticket: </span>
                                    <span id="resolver_numero_ticket" value="">OPE-0001</span>
                                </div>
                            </div>

                            <!-- user_id_solicitante (Oculto - Usamos o ID do usuário logado) -->
                            <div class="col-md-6 ">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Solicitante: </span>
                                    <span id="resolver_user_id_solicitante"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row w-100 align-items-center mt-4">
                            <!-- empresa_id (Select) -->
                            <div class="col-md-6 ">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Nome da Empresa: </span>
                                    <span id="resolver_empresa_id">Vasques e Neves e Filhos</span>
                                </div>
                            </div>
                            <!-- tipo_servico_id (Select) -->
                            <div class="col-md-6 ">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Serviço Solicitado</span>
                                    <span id="resolver_tipo_servico_id">Inativação de colaborador de empresa</span>
                                </div>
                            </div>
                        </div>

                        <div class=" w-100 align-items-center mt-4">
                            <!-- descricao_servico (TextArea - O principal detalhe) -->
                            <div class="d-flex flex-column">
                                <span class="fw-bold fs-7 text-info-emphasis">Descrição do Serviço: </span>
                                <div class=" border border-success bg-may-green-b p-3 rounded">
                                    <span id="resolver_descricao_servico" class="text-black"
                                        style="white-space: pre-wrap;"></span>
                                </div>
                            </div>

                        </div>

                        <!-- observacao Anteriores (TextArea - O principal detalhe) -->
                        <div class="form-group mb-1">
                            <label id="resolver_label_observacao" class="fs-6 form-label mb-2 text-info-emphasis"
                                for="resolver_observacao">Observações:</label>
                            <div class="border border-success form-control p-3 " id="resolver_observacoesAnteriores"
                                style="height: 100px; overflow-y: auto; white-space: pre-wrap; background-color: #A1C7C7;">
                                Sem Historico...{{ old('observacao') }}</div>
                            <input type="hidden" id="resolver_observacoesAnterioresInput"
                                name="observacoesAnteriores" />
                        </div>

                        <!-- observacao (TextArea - O principal detalhe) -->
                        <div class="form-group mb-3" id="resolver_observacao">
                            <label class="fs-6 form-label mb-2 text-info-emphasis" for="resolver_observacao">Motivo da
                                devolução:</label>
                            <textarea maxlength="2000" placeholder="Escreva o motivo da devolução..." class="border border-success form-control"
                                id="resolver_nova_observacao" name="observacoes" rows="3">{{ old('observacao') }}</textarea>
                        </div>
                        <!-- fim do modal-body -->
                    </div>
                </div>


                <!-- Rodape do Modal -->
                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()"
                            class="btn btn-danger">
                            <i class="bi bi-bookmark-x"></i>
                            Cancelar
                        </button>
                        <button type="submit" value="devolver" class="btn btn-warning" id="ResolverBtnDevolver">
                            <i class="bi bi-folder-symlink"></i>
                            Devolver para Solicitante
                        </button>
                        <button type="submit" value="encerrar" class="btn btn-primary border-1 border-black "
                            id="ResolverBtnEncerrar">
                            <i class="bi bi-journal-x"></i>
                            Encerrar Atendimento
                        </button>
                        <button type="submit" value="atender" class="btn btn-success border-1 border-black "
                            id="ResolverBtnAtender">
                            <i class="bi bi-headset"></i>
                            Atender Serviço
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

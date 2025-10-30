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
                    <div class="container-fluid p-0">
                        <div class="row w-100 align-items-center">
                            <!-- Coluna do título -->
                            <div class="col-md-8 col-12">
                                <h4 class="modal-title mb-0">Alterar Serviço</h4>
                            </div>

                            <!-- Coluna da data -->
                            <div class="col-md-4 col-12 text-md-end text-start">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold mb-0 text-primary-emphasis">Data da Solicitação</span>
                                    <span id="update_data_solicitacao_display"
                                        class=" text-secondary-emphasis">29/10/2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Corpo do formulário aberto e concluido -->
                <div class="modal-body" id="ModalBodyAberto">

                    <!-- Coluna 1: Informações de Serviço -->
                    <div class="form-cadastro container-fluid p-0">

                        <!-- numero_ticket (Pode ser gerado automaticamente, mas deixo como read-only) -->
                        <input type="hidden" class="form-control" id="update_user_departamento"
                            name="update_user_departamento" />
                        <input type="hidden" class="form-control" id="resolver_ticket_id" name="resolver_ticket_id" />


                        <!-- Solicitante E data da solicitação -->
                        <div class="row w-100 align-items-center">

                            <!-- Numero do Ticket -->
                            <div class="col-md-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Numero do Ticket: </span>
                                    <span id="update_numero_ticket" value="">OPE-0001</span>
                                </div>
                            </div>

                            <!-- user_id_solicitante (Oculto - Usamos o ID do usuário logado) -->
                            <div class="col-md-6 ">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Solicitante: </span>
                                    <span
                                        id="update_user_id_solicitante_display">{{ Auth::user()->name ?? 'Usuário Autenticado' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row w-100 align-items-center mt-4">
                            <!-- empresa_id (Select) -->
                            <div class="col-md-6 ">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Nome da Empresa: </span>
                                    <span id="update_empresa_id">Vasques e Neves e Filhos</span>
                                </div>
                            </div>
                            <!-- tipo_servico_id (Select) -->
                            <div class="col-md-6 ">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info-emphasis">Serviço Solicitado</span>
                                    <span id="update_tipo_servico_id">Inativação de colaborador de empresa</span>
                                </div>
                            </div>
                        </div>

                        <div class=" w-100 align-items-center mt-4">
                            <!-- descricao_servico (TextArea - O principal detalhe) -->
                            <div class="d-flex flex-column">
                                <span class="fw-bold fs-7 text-info-emphasis">Descrição do Serviço: </span>
                                <div class=" border border-success bg-may-green-b p-3 rounded">
                                    <span id="update_descricao_servico" class="text-black">
                                        O computador da recepção não está ligando. Já tentamos reiniciar e verificar os
                                        cabos, mas a tela permanece preta. Precisamos de um técnico para verificar o
                                        hardware o mais rápido possível, pois está impactando o atendimento aos
                                        clientes.
                                    </span>
                                </div>
                            </div>

                        </div>

                        <!-- observacao (TextArea - O principal detalhe) -->
                        <div class="form-group mb-3">
                            <label id="update_label_observacao" class="fs-6 form-label mb-2 text-info-emphasis"
                                for="update_observacao">Observações sobre o atendimento:</label>
                            <textarea maxlength="2000" placeholder="Descrição do Serviço..."
                                class="form-control @error('observacao') is-invalid @enderror" id="update_observacao" name="observacao"
                                rows="3">{{ old('observacao') }}</textarea>
                            @error('observacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- fim do modal-body -->
                    </div>
                </div>


                <!-- Rodape do Modal -->
                <div class="modal-footer bg-may-green-b">
                        <div class="flex justify-end gap-2">
                            <button type="button" value="Cancelar" data-bs-dismiss="modal"
                                onclick="event.target.blur()" class="btn btn-danger">
                                <i class="bi bi-bookmark-x"></i>
                                Cancelar
                            </button>
                            <button type="button" class="btn btn-warning">
                                <i class="bi bi-folder-symlink"></i>
                                Devolver
                            </button>
                            <button type="submit" value="aceitar" class="btn btn-success border-1 border-black "
                                id="ModalBodyButton">
                                <i class="bi bi-headset"></i>
                                Atender
                            </button>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>

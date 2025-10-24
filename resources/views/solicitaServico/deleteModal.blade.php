<!-- Create Modal DELETE SOLICITASERVICO HTML -->
<div class="modal fade" id="deleteSolicitaServicoModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteSolicitaServicoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="deleteSolicitaServico" id="deleteSolicitaServicoForm" action="" method="POST">
                @method('delete')
                @csrf

                <!-- Cabeçalho do formulário -->
                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Excluir Solicitação</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <!-- Nome da Grupo -->
                <div class="modal-body alert alert-danger m-0" id="ModalBodyStatusOutros">
                    <div class="container form-cadastro border border-danger p-4">
                        <span class="fw-bold fs-5">Atenção!</span> <br>
                        <span class="fs-6">Esta ação irá excluir o Ticket Nº: </span><label id="delete_numero_ticket"></label>
                        <br><br>
                        <span class="fs-5">Tem certeza que deseja continuar? </span>
                    </div>

                </div>

                <!-- Rodape do Modal -->
                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()"
                            class="btn btn-danger">
                            Cancelar
                        </button>
                        <button type="submit" value="Cadastrar" class="btn btn-success border-1 border-black "
                            id="ModalBodyButton">
                            Sim, excluir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

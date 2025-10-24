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

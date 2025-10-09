<!-- Create Modal DELETE TIPO_SERVICO HTML -->
<div class="modal fade" id="deleteTipoServicoModal" tabindex="-1" role="dialog" aria-labelledby="deleteTipoServicoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="deleteTipoServico" method="POST">
                @method('delete')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Deletar Tipo de Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <!-- Nome da Tipo de Serviço -->
                <div class="modal-body ">

                    <input type="hidden" name="delete_id" id="delete_id" />
                    <div class="form-group">
                        <label>Confirmar a exclusão do Tipo de Serviço:</label>
                   
                            <input type="text" class="form-control" name="delete_nome" id="delete_nome" value=""
                                style="border: 0; outline: 0; background: none; margin: 0;padding: 0; font-weight: bold;" readonly>

                    </div>

                </div>

                <div class="modal-footer">
                    <input type="button" class="btn btn-warning" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-danger" value="Excluir">

                </div>
            </form>
        </div>
    </div>
</div>
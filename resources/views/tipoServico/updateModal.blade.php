<!-- Create Modal UPDATE TIPO_SERVICO HTML -->
<div class="modal fade" id="updateTipoServicoModal" tabindex="-1" role="dialog" aria-labelledby="updateTipoServicoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="updateTipoServico" method="POST">
                @method('put')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Tipo de Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <!-- Nome da Tipo de Serviço -->
                    <input type="hidden" name="update_id" id="update_id" />
                    <div class="form-group">
                        <label>Nome do Tipo de Serviço:</label>
                        <input type="text" class="form-control" name="update_nome" id="update_nome" value=""
                            autofocus required>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="button" class="btn btn-warning" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" value="Alterar">

                </div>
            </form>
        </div>
    </div>
</div>
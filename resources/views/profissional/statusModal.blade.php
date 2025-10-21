<!-- Create Modal DELETE PROFISSIONAL HTML -->
<div class="modal fade" id="statusToggleProfissionalModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfissionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form name="statusToggleProfissional" id="statusToggleform" method="POST" action="">
                @method('POST')
                @csrf

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Inativar Profissional</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <!-- Nome da Grupo -->
                <div class="modal-body alert alert-warning m-0">
                    <div class="container form-cadastro border border-danger p-4">
                        <input type="hidden" name="status_id" id="status_id">
                        <input type="hidden" name="status_status" id="status_status">
                        <span class="fw-bold fs-5">Atenção!</span> <br><br>
                        <span class="fs-6">Esta ação irá inativar o Profissional:</span>
                        <br><br>
                        <strong><span id="status_nome"></span></strong>
                        <br><br>
                        <span class="fs-6">Tem certeza que deseja continuar?</span>
                    </div>
                </div>

                <div class="modal-footer bg-may-green-b">
                    <input type="button" class="btn btn-danger btn-default" data-bs-dismiss="modal" value="Cancelar" onclick="event.target.blur()">
                    <input type="submit" class="btn btn-success border-1 border-black btn-confirmar-status" value="Alterar Status">
                </div>
            </form>
        </div>
    </div>
</div>
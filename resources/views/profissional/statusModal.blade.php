<!-- Create Modal DELETE PROFISSIONAL HTML -->
<div class="modal fade" id="statusToggleProfissionalModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfissionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="statusToggleProfissional" id="statusToggleform" method="POST" action="">
                @method('POST')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Inativar Profissional</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <!-- Nome da Grupo -->
                <div class="modal-body ">

                    <input type="hidden" name="status_id" id="status_id" >
                    <input type="hidden" name="status_status" id="status_status" >
                    <div class="alert alert-warning">
                        <strong>Atenção!</strong> <br> <br> Esta ação irá alterar o status do Profissional <strong><span id="status_nome"></span></strong> 
                        <br><br>
                        Tem certeza que deseja continuar?
                    </div>

                </div>

                <div class="modal-footer">
                    <!-- <input type="button" class="btn btn-warning" data-bs-dismiss="modal" value="Cancelar"> -->
                    <input type="button" class="btn btn-warning btn-cancelar" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-primary btn-confirmar-status" value="Alterar Status">

                </div>
            </form>
        </div>
    </div>
</div>
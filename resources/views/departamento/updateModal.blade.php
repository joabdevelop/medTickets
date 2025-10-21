<!-- Create Modal UPDATE DEPARTAMENTO HTML -->
<div class="modal fade" id="updateDepartamentoModal" tabindex="-1" role="dialog" aria-labelledby="updateDepartamentoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form name="updateDepartamento" method="POST" action="">
                @method('put')
                @csrf

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Departamento</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <div class="modal-body">

                    <div class="container form-cadastro">

                        <!-- Nome do Departamento -->
                        <input type="hidden" name="update_id" id="update_id" />
                        <div class="form-group">
                            <label>Nome do Departamento:</label>
                            <input type="text" class="form-control" name="update_nome" id="update_nome" value=""
                                oninput="capitalizeInput(this)" required>
                        </div>

                        <div class="form-group mt-2 mb-3">
                            <label>Sigla do Departamento:</label>
                            <input type="text" class="form-control" name="update_sigla" id="update_sigla" value=""
                                oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-may-green-b">
                    <input type="button" class="btn btn-danger btn-default" data-bs-dismiss="modal" value="Cancelar" onclick="event.target.blur()">
                    <input type="submit" class="btn btn-success border-1 border-black" value="Alterar">

                </div>
            </form>
        </div>
    </div>
</div>
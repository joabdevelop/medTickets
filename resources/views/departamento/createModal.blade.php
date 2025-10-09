<!-- Create Modal CREATE DEPARTAMENTO HTML -->
<div class="modal fade" id="createDepartamentoModal" tabindex="-1" role="dialog" aria-labelledby="createDepartamentoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="createDepartamento" method="POST" action="{{ route('departamento.store') }}">
                @method('post')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Incluir Departamento</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <!-- Nome da Grupo -->
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label>Nome do Departamento:</label>
                        <input type="text" class="form-control" name="create_nome" id="create_nome" value=""
                            oninput="capitalizeInput(this)" required>
                    </div>

                    <div class="form-group">
                        <label>Sigla do Departamento:</label>
                        <input type="text" class="form-control" name="create_sigla" id="create_sigla" value=""
                            oninput="this.value = this.value.toUpperCase()" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="button" class="btn btn-warning btn-default" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" value="Gravar">

                </div>
            </form>
        </div>
    </div>
</div>
<!-- Create Modal CREATE GRUPO HTML -->
<div class="modal fade" id="createGrupoModal" tabindex="-1" role="dialog" aria-labelledby="createGrupoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="createGrupo" method="POST" action="{{ route('grupo.store') }}">
                @method('post')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Incluir Grupo</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">
                    
                    <!-- Nome da Grupo -->
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label>Nome do Grupo:</label>
                        <input type="text" class="form-control" name="create_nome" id="create_nome" value=""
                            required>
                    </div>

                    <!-- Nome do Relacionamento -->
                    <div class="form-group mt-4">
                        <label>Nome do Relacionamento:</label>
                        <select name="create_relacionamento" id="create_relacionamento">
                            @foreach ($relacionamentos as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" value="Gravar">

                </div>
            </form>
        </div>
    </div>
</div>
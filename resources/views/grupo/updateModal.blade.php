<!-- Create Modal UPDATE GRUPO HTML -->
<div class="modal fade" id="updateGrupoModal" tabindex="-1" role="dialog" aria-labelledby="updateGrupoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @php
            $grupo = $grupo ?? null;
            @endphp
            <form name="updateGrupo" method="POST">
                @method('put')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Grupo</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <!-- Nome da Grupo -->
                    <input type="hidden" name="update_id" id="update_id" />
                    <div class="form-group">
                        <label>Nome do Grupo:</label>
                        <input type="text" class="form-control" name="update_nome" id="update_nome" value=""
                            autofocus required>
                    </div>
                    <!-- Nome do Relacionamento -->
                    <div class="form-group mt-4">
                        <label>Nome do Relacionamento:</label>
                        <select name="update_relacionamento" id="update_relacionamento">
                            @foreach ($relacionamentos as $id => $name)                            
                            <option value="{{ $id }}"
                                {{ ($grupo && $grupo->relacionamento_id == $id) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
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
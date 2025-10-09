<!-- Create Modal UPDATE PROFISSIONAL HTML -->
<div class="modal fade" id="updateProfissionalModal" tabindex="-1" role="dialog" aria-labelledby="updateProfissionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="updateProfissional" method="POST">
                @method('put')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Profissional</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <input type="hidden" name="id" id="update_id" value="" readonly>

                    <!-- Email Profissional -->
                    <div class="form-group mt-4">
                        <label>Email do Profissional:</label>
                        <input type="email" class="form-control" name="update_email" id="update_email" value=""
                            required>
                    </div>

                    <!-- Nome da Profissional -->
                    <div class="form-group mt-4">
                        <label>Nome do Profissional:</label>
                        <input type="text" class="form-control" name="update_nome" id="update_nome" value=""
                            required>
                    </div>

                    <!-- Telefone -->
                    <div class="form-group mt-4">
                        <label>Telefone:</label>
                        <input type="tel" class="form-control" name="update_telefone" id="update_telefone" value=""
                            required>
                    </div>

                     <!-- Tipo de Usuario -->
                    <div class="form-group mt-4">
                        <label>Tipo de Usuario:</label>
                        <select name="update_tipo_usuario" id="update_tipo_usuario">
                            <option value="1">Cliente</option>
                            <option value="2" selected>Funcionário</option>
                        </select>
                    </div>

                    <!-- Departamento -->
                    <div class="form-group mt-4">
                       <label>Nome do Departamento:</label>
                        <select name="update_departamento" id="update_departamento">
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nome}}</option>
                            @endforeach
                        </select>                            
                    </div>

                    <!-- Tipo de Acesso -->
                    <div class="form-group mt-4">
                        <label>Tipo de Acesso:</label>
                        <select name="update_tipo_acesso" id="update_tipo_acesso">
                            <option value="Admin">Admin</option>
                            <option value="Gestor">Gestor</option>
                            <option value="PDD">PDD</option>
                            <option value="Relacionamento">Relacionamento</option>
                            <option value="Operacional">Operacional</option>
                            <option value="ÁreaTécnica">Área Técnica</option>
                            <option value="SemAcesso" selected>Sem Acesso</option>
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
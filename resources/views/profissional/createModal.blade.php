<!-- Create Modal CREATE PROFISSIONAL HTML -->
<div class="modal fade" id="createProfissionalModal" tabindex="-1" role="dialog" aria-labelledby="createProfissionalModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document ">
        <div class="modal-content">
            <form name="createProfissional" method="POST" action="{{ route('profissional.store') }}">
                @method('post')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Incluir Profissional</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <input type="hidden" name="id" id="id" />

                    <!-- Email Profissional -->
                    <div class="form-group mt-4">
                        <label>Email do Profissional:</label>
                        <input type="email" class="form-control" name="create_email" id="create_email" value=""
                            required>
                    </div>

                    <!-- Nome da Profissional -->
                    <div class="form-group mt-4">
                        <label>Nome do Profissional:</label>
                        <input type="text" class="form-control" name="create_nome" id="create_nome" value=""
                            required>
                    </div>

                    <!-- Telefone -->
                    <div class="form-group mt-4">
                        <label>Telefone:</label>
                        <input type="tel" class="form-control" name="create_telefone" id="create_telefone" value=""
                            required>
                    </div>

                     <!-- Tipo de Usuario -->
                    <div class="form-group mt-4">
                        <label>Tipo de Usuario:</label>
                        <select name="create_tipo_usuario" id="create_tipo_usuario">
                            <option value="1">Cliente</option>
                            <option value="2" selected>Funcionário</option>
                        </select>
                    </div>

                    <!-- Departamento -->
                    <div class="form-group mt-4">
                       <label>Nome do Departamento:</label>
                        <select name="create_departamento" id="create_departamento">
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nome}}</option>
                            @endforeach
                        </select>                            
                    </div>

                    <!-- Tipo de Acesso -->
                    <div class="form-group mt-4">
                        <label>Tipo de Acesso:</label>
                        <select name="create_tipo_acesso" id="create_tipo_acesso">
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
                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" value="Gravar">

                </div>
            </form>
        </div>
    </div>
</div>
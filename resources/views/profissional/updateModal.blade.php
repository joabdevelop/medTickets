<!-- Create Modal UPDATE PROFISSIONAL HTML -->
<div class="modal fade" id="updateProfissionalModal" tabindex="-1" role="dialog" aria-labelledby="updateProfissionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form name="updateProfissional" method="POST">
                @method('put')
                @csrf

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Profissional</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <div class="modal-body">

                    <div class="container form-cadastro">

                        <input type="hidden" name="id" id="update_id" value="" readonly>

                        <!-- Email Profissional -->
                        <div class="form-group mt-4">
                            <label>Email do Profissional:</label>
                            <input type="email" class="form-control" name="update_email" id="update_email" value="" readonly>
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

                        <div class="row">
                            <!-- Tipo de Usuario -->
                            <div class="form-group mt-4 col-md-6">
                                <label>Tipo de Usuario:</label>
                                <select name="update_tipo_usuario" class="form-select form-control" id="update_tipo_usuario">
                                    <option value="1">Funcionário</option>
                                    <option value="2" selected>Cliente</option>
                                </select>
                            </div>
                            <!-- Nome do GRUPO -->
                            <div class="form-group mt-4 col-md-6">
                                <label>Nome do Grupo:</label>
                                <select name="update_grupo" class="form-select form-control" id="update_grupo">
                                    @foreach ($grupos as $id => $nome_grupo)
                                    <option value="{{ $id }}">{{ $nome_grupo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Departamento -->
                            <div class="form-group mt-4 col-md-6">
                                <label>Nome do Departamento:</label>
                                <select name="update_departamento" class="form-select form-control" id="update_departamento">
                                    @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tipo de Acesso -->
                            <div class="form-group mt-4 col-md-6">
                                <label>Tipo de Acesso:</label>
                                <select name="update_tipo_acesso" class="form-select form-control" id="update_tipo_acesso">
                                    @foreach ($tiposAcessos as $tiposAcesso)
                                    <option value="{{ $tiposAcesso->value }}">{{ $tiposAcesso->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-may-green-b">
                    <input type="button" class="btn btn-danger btn-default" data-bs-dismiss="modal" value="Cancelar" onclick="event.target.blur()">
                    <input type="submit" class="btn btn-success border-1 border-black" value="Gravar">
                </div>
            </form>
        </div>
    </div>
</div>
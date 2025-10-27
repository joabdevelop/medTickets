<!-- Create Modal CREATE GRUPO HTML -->
<div class="modal fade" id="createSolicitaServicoModal" tabindex="-1" role="dialog"
    aria-labelledby="createSolicitaServicoModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <form name="createGrupo" method="POST" action="{{ route('solicitaServico.store') }}">
                @method('post')
                @csrf

                <!-- Cabeçalho do formulário -->
                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Solicitar Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">



                    <!-- Coluna 1: Informações de Serviço -->
                    <div class="form-cadastro">

                        <!-- numero_ticket (Pode ser gerado automaticamente, mas deixo como read-only) -->
                        <input type="hidden" class="form-control" id="create_numero_ticket" name="numero_ticket" />
                        <input type="hidden" class="form-control" id="create_user_departamento"
                            name="create_user_departamento" />
                        <input type="hidden" class="form-control" id="create_user_id" name="create_user_id" />


                        <!-- Solicitante E data da solicitação -->
                        <div class="row">

                            <!-- user_id_solicitante (Oculto - Usamos o ID do usuário logado) -->
                            <div class="form-group mb-3 col-md-6 ">
                                <label for="create_user_id_solicitante_display" class="form-label">Nome do
                                    Solicitante</label>
                                <input type="text" class="form-control" id="create_user_id_solicitante_display"
                                    value="{{ Auth::user()->name ?? 'Usuário Autenticado' }}" readonly>
                                <input type="hidden" name="user_id_solicitante" value="{{ Auth::id() }}">
                            </div>

                            <!-- data_solicitacao (Opcional se for automático) -->
                            <div class="col-md-6">
                                <label for="create_data_solicitacao" class="form-label">Data de Solicitação</label>
                                <input type="date"
                                    class="form-control @error('data_solicitacao') is-invalid @enderror"
                                    id="create_data_solicitacao" name="data_solicitacao"
                                    value="{{ old('data_solicitacao', now()->toDateString()) }}" readonly>
                            </div>

                        </div>

                        <!-- empresa_id (Select) -->
                        <div class="form-group mb-2">
                            <label>Nome da Empresa</label>
                            <select class="form-select form-control @error('empresa_id') is-invalid @enderror"
                                id="create_empresa_id" name="empresa_id" required>
                                <option value="" disabled selected>Selecione a Empresa</option>
                                @foreach ($empresas as $id => $nome_fantasia)
                                    <option value="{{ $id }}"
                                        {{ old('empresa_id') == $id ? 'selected' : '' }}>{{ $nome_fantasia }}</option>
                                @endforeach
                            </select>
                            @error('empresa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- tipo_servico_id (Select) -->
                        <div class="form-group mb-3">
                            <label for="create_tipo_servico_id" class="form-label">Qual Tipo de Serviço</label>
                            <select id="create_tipo_servico_id" name="tipo_servico_id" class="form-select form-control"
                                required>
                                <option value="" disabled selected>Selecione o Tipo de Serviço</option>
                                @foreach ($tiposServicos as $tipo)
                                    <option value="{{ $tipo->id }}" data-titulo_nome="{{ e($tipo->titulo_nome) }}"
                                        {{ old('tipo_servico_id') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nome_servico }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_servico_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- descricao_servico (TextArea - O principal detalhe) -->
                        <div class="form-group mb-3">
                            <label id="label_descricao_servico" class="fs-5 form-label mb-2"
                                for="create_descricao_servico">Aguardando a seleção...</label>
                            <textarea maxlength="2000" placeholder="Descrição do Serviço..."
                                class="form-control @error('descricao_servico') is-invalid @enderror" id="create_descricao_servico"
                                name="descricao_servico" rows="5" required>{{ old('descricao_servico') }}</textarea>
                            @error('descricao_servico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- anexar arquivos -->
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                            <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>

                        <!-- fim do modal-body -->
                    </div>
                </div>

                <!-- Rodape do Modal -->
                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()"
                            class="btn btn-danger">
                            Cancelar
                        </button>
                        <button type="submit" value="Cadastrar" class="btn btn-success border-1 border-black">
                            Solicitar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

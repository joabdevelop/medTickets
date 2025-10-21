<!-- update Modal UPDATE GRUPO HTML -->
<div class="modal fade" id="updateSolicitaServicoModal" tabindex="-1" role="dialog" aria-labelledby="updateSolicitaServicoModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <form name="updateGrupo" id="updateSolicitaServicoForm" method="POST" action="">
                @method('PUT')
                @csrf

                <!-- Cabeçalho do formulário -->
                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <!-- Coluna 1: Informações de Serviço -->
                    <div class="form-cadastro">

                        <!-- numero_ticket (Pode ser gerado automaticamente, mas deixo como read-only) -->
                        <input type="hidden" class="form-control" id="update_numero_ticket1" name="numero_ticket"/>
                        <input type="hidden" class="form-control" id="update_user_departamento" name="update_user_departamento" />
                        <input type="hidden" class="form-control" id="update_user_id" name="update_user_id" />
                        <input type="hidden" class="form-control" id="update_status_final" name="update_status_final" />

                        <!-- Solicitante E data da solicitação -->
                        <div class="row">

                            <!-- Numero do Ticket -->
                            <div class="mb-2">
                                <span class="fw-bold  "> Numero do Ticket: </span>
                                <span  id="update_numero_ticket" value=""></span>
                            </div>

                            <!-- user_id_solicitante (Oculto - Usamos o ID do usuário logado) -->
                            <div class="form-group mb-3 col-md-6 ">
                                <label for="update_user_id_solicitante_display" class="form-label">Nome do Solicitante</label>
                                <input type="text" class="form-control" id="update_user_id_solicitante_display" value="{{ Auth::user()->name ?? 'Usuário Autenticado' }}" readonly>
                                <input type="hidden" name="user_id_solicitante" value="{{ Auth::id() }}">
                            </div>

                            <!-- data_solicitacao (Opcional se for automático) -->
                            <div class="col-md-6">
                                <label for="update_data_solicitacao" class="form-label">Data de Solicitação</label>
                                <input type="date" class="form-control @error('data_solicitacao') is-invalid @enderror" id="update_data_solicitacao" name="data_solicitacao" readonly>
                            </div>

                        </div>

                        <!-- empresa_id (Select) -->
                        @if(Auth::check() && \App\Models\Profissional::where('user_id', Auth::id())->where('tipo_acesso', '!=', 'Cliente')->exists())
                        <div class="form-group mb-2">
                            <label for="update_empresa_id" class="form-label">Nome da Empresa</label>
                            <select class="form-select form-control @error('empresa_id') is-invalid @enderror" id="update_empresa_id" name="empresa_id" required>
                                <option value="" disabled selected>Selecione a Empresa</option>
                                @foreach ($empresas as $id => $razao_social)
                                <option value="{{ $id }}" {{ old('empresa_id') == $id ? 'selected' : '' }}>{{ $razao_social }}</option>
                                @endforeach
                            </select>
                            @error('empresa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @endif

                        <!-- tipo_servico_id (Select) -->
                        <div class="form-group mb-3">
                            <label for="update_tipo_servico_id" class="form-label">Qual Tipo de Serviço</label>
                            <select id="update_tipo_servico_id" name="tipo_servico_id" class="form-select form-control" required>
                                <option value="" disabled selected>Selecione o Tipo de Serviço</option>
                                @foreach($tiposServicos as $tipo)
                                <option
                                    value="{{ $tipo->id }}"
                                    data-titulo_nome="{{ e($tipo->titulo_nome) }}"
                                    {{ old('tipo_servico_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nome_servico }}
                                </option>
                                @endforeach
                            </select>
                            @error('tipo_servico_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- descricao_servico (TextArea - O principal detalhe) -->
                        <div class="form-group mb-3">
                            <label id="update_label_descricao_servico" class="fs-5 form-label mb-2" for="update_descricao_servico">Aguardando a seleção...</label>
                            <textarea
                                maxlength="2000"
                                placeholder="Descrição do Serviço..."
                                class="form-control @error('descricao_servico') is-invalid @enderror"
                                id="update_descricao_servico"
                                name="descricao_servico"
                                rows="5"
                                required>{{ old('descricao_servico') }}</textarea>
                            @error('descricao_servico')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- anexar arquivos -->
                        <div class="form-group mb-3">
                            <label for="update_anexar_arquivos" class="form-label">Anexar Arquivos</label>
                            <input type="file" class="form-control @error('anexar_arquivos') is-invalid @enderror" id="update_anexar_arquivos" name="anexar_arquivos[]" multiple>
                            @error('anexar_arquivos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- fim do modal-body -->
                    </div>
                </div>

                <!-- Rodape do Modal -->
                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()" class="btn btn-danger">
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
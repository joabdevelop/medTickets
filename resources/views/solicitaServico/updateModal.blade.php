<!-- update Modal UPDATE GRUPO HTML -->
<div class="modal fade" id="updateSolicitaServicoModal" tabindex="-1" role="dialog"
    aria-labelledby="updateSolicitaServicoModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered scrollable" role="document ">
        <div class="modal-content ">

            <form name="updateGrupo" class="formUpdate" id="updateSolicitaServicoForm" method="POST" action="">
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

                <!-- Alerta de Status Outros -->
                <div class="modal-body alert alert-warning m-0" id="ModalBodyStatusOutros">
                    <div class="container form-cadastro border border-danger p-4">
                        <span class="fw-bold fs-5">Atenção!</span> <br><br>
                        <span class="fs-6">A solicitação do Ticket </span><span class="fw-bold"
                            id="update_numero_ticket_outros"></span>
                        <span class="fs-6">está com o status </span><span class="fw-bold"
                            id="update_status_final_outros"></span>.
                        <br><br>
                        <span class="fs-6">Por favor, entre em contato com o Suporte.</span>
                    </div>
                </div>

                <!-- Alerta de Status Concluido -->
                <div class="modal-body alert alert-success m-0" role="alert" id="ModalBodyStatusConcluido">
                    <div class="container form-cadastro p-4">
                        <span class="fw-bold fs-5">Atenção!</span> <br><br>
                        <span class="fs-6">A solicitação do Ticket </span><span class="fw-bold"
                            id="update_numero_ticket_concluido"></span>
                        <span class="fs-6">foi </span><span class="fw-bold"
                            id="update_status_final_concluido"></span>.
                        <br><br>
                        <span class="fs-6">Qualquer duvida, entre em contato com o Suporte.</span>
                    </div>
                </div>

                <!-- Corpo do formulário aberto e concluido -->
                <div class="modal-body" id="ModalBodyAberto">

                    <!-- Coluna 1: Informações de Serviço -->
                    <div class="form-cadastro">

                        <!-- numero_ticket (Pode ser gerado automaticamente, mas deixo como read-only) -->
                        <input type="hidden" class="form-control" id="update_user_departamento"
                            name="update_user_departamento" />
                        <input type="hidden" class="form-control" id="update_user_id" name="update_user_id" />
                        <input type="hidden" class="form-control" id="update_statusFinal" name="update_statusFinal" />
                        <input type="hidden" class="form-control" id="update_user_executante_id" name="update_user_executante_id" />

                        <!-- Campo de observacoes Para quando for devolvido -->
                        <div class="form-group mb-1" id="ModalBodyDevolvido">
                            <label class="fs-6 form-label mb-2 text-info-emphasis"
                                for="update_observacoes">Motivo da Devolução:</label>
                            <div class="border border-success form-control p-3 " id="update_observacoes"
                                name="observacoes"
                                style="height: 100px; overflow-y: auto; white-space: pre-wrap; background-color: #A1C7C7;">Sem Historico...{{ old('observacao') }}</div>
                        </div>
                        

                        <!-- Solicitante E data da solicitação -->
                        <div class="row">

                            <!-- Numero do Ticket -->
                            <div class="mb-2">
                                <span class="fw-bold  "> Numero do Ticket: </span>
                                <span id="update_numero_ticket" value=""></span>
                            </div>

                            <!-- user_id_solicitante (Oculto - Usamos o ID do usuário logado) -->
                            <div class="form-group mb-3 col-md-6 ">
                                <label for="update_user_id_solicitante_display" class="form-label">Nome do
                                    Solicitante</label>
                                <input type="text" class="form-control" id="update_user_id_solicitante_display"
                                    value="{{ Auth::user()->name ?? 'Usuário Autenticado' }}" readonly>
                                <input type="hidden" name="user_id_solicitante" value="{{ Auth::id() }}">
                            </div>

                            <!-- data_solicitacao (Opcional se for automático) -->
                            <div class="col-md-6">
                                <label for="update_data_solicitacao" class="form-label">Data de Solicitação</label>
                                <input type="date"
                                    class="form-control @error('data_solicitacao') is-invalid @enderror"
                                    id="update_data_solicitacao" name="data_solicitacao" readonly>
                            </div>

                        </div>

                        <!-- empresa_id (Select) -->
                        <div class="form-group mb-2">
                            <label for="update_empresa_id" class="form-label">Nome da Empresa</label>
                            <select class="form-select form-control @error('empresa_id') is-invalid @enderror"
                                id="update_empresa_id" name="empresa_id" required>
                                <option value="" disabled selected>Selecione a Empresa</option>
                                @foreach ($empresas as $id => $nome_fantasia)
                                    <option value="{{ $id }}">{{ $nome_fantasia }}</option>
                                @endforeach
                            </select>

                            @error('empresa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- tipo_servico_id (Select) -->
                        <div class="form-group mb-3">
                            <label for="update_tipo_servico_id" class="form-label">Qual Tipo de Serviço</label>
                            <select id="update_tipo_servico_id" name="tipo_servico_id" class="form-select form-control"
                                required>
                                <option value="" disabled selected>Selecione o Tipo de Serviço</option>
                                @foreach ($tiposServicos as $tipo)
                                    <option value="{{ $tipo->id }}" data-titulo_nome="{{ e($tipo->titulo_nome) }}">
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
                            <label id="update_label_descricao_servico" class="fs-5 form-label mb-2"
                                for="update_descricao_servico">Aguardando a seleção...</label>
                            <textarea maxlength="2000" placeholder="Descrição do Serviço..."
                                class="form-control @error('descricao_servico') is-invalid @enderror" id="update_descricao_servico"
                                name="descricao_servico" rows="5" required style="white-space: pre-wrap;">{{ old('descricao_servico') }}</textarea>
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
                        <button type="button" value="Cancelar" data-bs-dismiss="modal"
                            onclick="event.target.blur()" class="btn btn-danger">
                            Cancelar
                        </button>
                        <button type="submit" value="Cadastrar" class="btn btn-success border-1 border-black "
                            id="ModalBodyButton">
                            Solicitar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

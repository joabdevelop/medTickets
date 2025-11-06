<!-- Create Modal UPDATE TIPO_SERVICO HTML -->
<div class="modal fade" id="updateTipoServicoModal" tabindex="-1" role="dialog"
    aria-labelledby="updateTipoServicoModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <form name="createTipoServico" method="POST" id="updateTipoServicoForm">
                @method('PUT')
                @csrf

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Alterar Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <div class="modal-body ">

                    <!-- conteiner da tela -->
                    <div class="container ">

                        <!-- Primeira div -->

                        <div class="row form-cadastro">

                            <!-- Nome da Tipo de Serviço -->
                            <input type="hidden" name="id" id="id" />

                            <div class="form-group">
                                <label class="form-label m-0">Nome do Serviço:</label>
                                <input type="text" class="form-control" name="update_nome_servico"
                                    id="update_nome_servico" required value="{{ old('update_nome_servico') }}">
                            </div>

                            <!-- nome da solicitacao -->
                            <div class="form-group mt-2">
                                <label class="form-label mb-0">Titulo da solicitação:</label>
                                <input type="text" class="form-control" name="update_titulo_nome"
                                    id="update_titulo_nome" rows="3" required>
                            </div>

                            <div class="form-group mt-2">
                                <label>Prioridade:</label>
                                <select name="update_prioridade" id="update_prioridade" class="form-select form-control"
                                    required>
                                    <option value="" disabled selected>Selecione</option>
                                    @foreach ($prioridades as $prioridade)
                                        <option value="{{ $prioridade->value }}">{{ $prioridade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label>SLA:</label>
                                <select name="update_sla" id="update_sla" class="form-select form-control" required>
                                    <option value="" disabled selected>Selecione</option>
                                    @foreach ($slas as $id => $nome_sla)
                                        <option value="{{ $id }}">{{ $nome_sla }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label>Quem Executa o Serviço:</label>
                                <select class="form-select form-control" name="update_executante_departamento_id"
                                    id="update_executante_departamento_id" required>
                                    @foreach ($departamentos as $id => $nome)
                                        <option value="{{ $id }}">{{ $nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label>Quem Solicita o Serviço:</label>
                                <select name="update_quem_solicita" id="update_quem_solicita"
                                    class="form-select form-control" required>
                                    <option value="" disabled selected>Selecione</option>
                                    @foreach ($quemSolicitas as $quemSolicita)
                                        <option value="{{ $quemSolicita->value }}">{{ $quemSolicita->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div style="display: none;">
                                <input type="hidden" name="update_dados_add" id="update_dados_add" value="">
                                <input type="checkbox" name="update_servico_ativo" id="update_servico_ativo">
                            </div>


                        </div>

                    </div>
                </div>
                <!-- Fim conteiner da tela -->
                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()"
                            class="btn btn-danger">
                            Cancelar
                        </button>
                        <button type="submit" value="Cadastrar" class="btn btn-success border-1 border-black">
                            Alterar Serviço
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

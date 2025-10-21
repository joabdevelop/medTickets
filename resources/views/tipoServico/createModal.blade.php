<!-- Create Modal CREATE TIPO_SERVICO HTML -->
<div class="modal fade" id="createTipoServicoModal" tabindex="-1" role="dialog" aria-labelledby="createTipoServicoModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <form name="createTipoServico" method="POST" action="{{ route('tipo_servico.store') }}">
                @method('post')
                @csrf

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Incluir Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                <div class="modal-body ">

                    <!-- conteiner da tela -->
                    <div class="container ">

                        <!-- Primeira div -->


                        <div class="modal-body">

                            <div class="row form-cadastro">

                                <!-- Nome da Tipo de Serviço -->
                                <input type="hidden" name="id" id="id" />

                                <div class="form-group">
                                    <label class="form-label m-0">Nome do Serviço:</label>
                                    <input type="text" class="form-control" name="create_nome_servico" id="create_nome_servico" rows="3" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label class="form-label mb-0">Titulo da solicitação:</label>
                                    <input type="text" class="form-control" name="create_titulo_nome" id="create_titulo_nome" rows="3" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Prioridade:</label>
                                    <select name="create_prioridade" id="create_prioridade" class="form-select form-control" required>
                                        <option value="" disabled selected>Selecione</option>
                                        <option value="baixa">Baixa</option>
                                        <option value="media">Média</option>
                                        <option value="alta">Alta</option>
                                        <option value="urgente">Urgente</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>SLA:</label>
                                    <select name="create_sla" id="create_sla" class="form-select form-control" required>
                                        <option value="" disabled selected>Selecione</option>
                                        @foreach ($slas as $id => $nome_sla)
                                        <option value="{{ $id }}">{{ $nome_sla }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Quem Executa o Serviço:</label>
                                    <select class="form-select form-control" name="create_executante_departamento_id" id="create_executante_departamento_id" required>
                                        <option value="" disabled selected>Selecione</option>
                                        @foreach ($departamentos as $id => $nome)
                                        <option value="{{ $id }}">{{ $nome }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-2 mb-2">
                                    <label>Quem Solicita o Serviço:</label>
                                    <select name="create_quem_solicita" id="create_quem_solicita" class="form-select form-control" required>
                                        <option value="" disabled selected>Selecione</option>
                                        <option value="0">Equipe interna e Cliente</option>
                                        <option value="1">Equipe Interna</option>
                                        <option value="2">Cliente</option>
                                    </select>
                                </div>


                                <div style="display: none;">
                                    <input type="hidden" name="create_dados_add" id="create_dados_add" value="1">
                                    <input type="hidden" name="create_servico_ativo" id="create_servico_ativo" value="1">
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
                <!-- Fim conteiner da tela -->
                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()" class="btn btn-danger">
                            Cancelar
                        </button>
                        <button type="submit" value="Cadastrar" class="btn btn-success border-1 border-black">
                            Cadastrar Serviço
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
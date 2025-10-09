<!-- Create Modal CREATE TIPO_SERVICO HTML -->
<div class="modal fade" id="createTipoServicoModal" tabindex="-1" role="dialog" aria-labelledby="createTipoServicoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="createTipoServico" method="POST" action="{{ route('tipo_servico.store') }}">
                @method('post')
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Incluir Tipo de Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>


                <div class="modal-body">

                    <!-- Nome da Tipo de Serviço -->
                    <input type="hidden" name="id" id="id" />

                    <div class="form-group mt-4">
                        <label>Descrição do Serviço:</label>
                        <input type="text" class="form-control" name="create_descricao_servico" id="create_descricao_servico" rows="3" required>
                    </div>
                    <div class="form-group mt-4">
                        <label>Prioridade:</label>
                        <select name="create_prioridade" id="create_prioridade" class="form-control" required>
                            <option value="" disabled selected>Selecione a prioridade</option>
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                            <option value="Urgente">Urgente</option>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label>Acordo de nivel de serviço - SLA (em horas):</label>
                        <select name="create_acordo_sla" id="create_acordo_sla" class="form-control" required>
                            <option value="" disabled selected>Selecione o SLA</option>
                            <option value="1">1 hora</option>
                            <option value="2">2 horas</option>
                            <option value="4">4 horas</option>
                            <option value="8">8 horas</option>
                            <option value="12">12 horas</option>
                            <option value="24">24 horas</option>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label>Executado por:</label>
                        <select class="form-control" name="create_departamento_id" id="create_departamento_id" required>
                            <option value="" disabled selected>Selecione o departamento</option>
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nome }}</option>
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
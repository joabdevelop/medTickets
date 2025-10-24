<!-- Create Modal CREATE GRUPO HTML -->
<div class="modal fade" id="createSolicitaServicoModal" tabindex="-1" role="dialog" aria-labelledby="createSolicitaServicoModalLabel"
    aria-hidden="true">

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
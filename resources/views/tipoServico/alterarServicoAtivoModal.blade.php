<!-- Create Modal SERVICO ATIVO Modal HTML -->
<div class="modal fade" id="alterarServicoAtivoModal" tabindex="-1" role="dialog" aria-labelledby="alterarServicoAtivoModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <form name="toggleServicoAtivo" method="POST" action="">
                @method('PUT')
                @csrf

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Status do Serviço</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>



                <div class="alert alert-warning m-0">




                    <strong>Atenção!</strong>
                    <br>
                    Esta ação irá alterar o status do Serviço:
                    <br><br>
                    <strong><span id="nome_servico"class="text-black"></span></strong>
                    <br><br>
                    Tem certeza que deseja continuar?
                    <br>


                </div>

                <!-- Fim conteiner da tela -->
                <div class="modal-footer bg-may-green-b ">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" onclick="event.target.blur()" class="btn btn-danger">
                            Não Alterar
                        </button>
                        <button type="submit" value="status" class="btn btn-success border-1 border-black">
                            Sim Alterar
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
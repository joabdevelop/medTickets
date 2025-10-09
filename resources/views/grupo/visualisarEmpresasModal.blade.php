<!-- Create Modal VISUALIZAR EMPRESAS HTML -->
<div class="modal fade" id="visualizarEmpresasModal" tabindex="-1" role="dialog" aria-labelledby="visualizarEmpresasModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-6">
                    <h4 class="modal-title">Incluir Grupo</h4>
                </div>
                <div class="col-md-6">
                    <h1 id="message"></h1>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nome da Empresa</th>
                    </tr>
                </thead>

                <tbody id="empresas-list"></tbody>
                
            </table>

            <div class="modal-footer">
                <input type="button" class="btn btn-warning" data-bs-dismiss="modal" value="Voltar">
            </div>
        </div>
    </div>
</div>
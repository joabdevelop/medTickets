<!-- Create Modal CREATE EMPRESA HTML -->
<div class="modal fade" id="createEmpresaModal" tabindex="-1" role="dialog" aria-labelledby="createEmpresaModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document ">
        <div class="modal-content ">

            <form method="POST" action="{{ route('empresa.store') }}">
                @csrf
                @method('post')

                <div class="modal-header bg-may-green-t">
                    <div class="col-md-6">
                        <h4 class="modal-title">Cadastro de Nova Empresa</h4>
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

                            <div class="row">

                                <!-- fica em uma linha -->
                                <div class="col-lg-3 ">
                                    <label for="grupo_empresarial" class="form-label"><b>1 </b>- Grupo</label>
                                    <select id="grupo_empresarial_select" class="form-select form-control" name="grupo_empresarial">
                                        <option value="">Selecione </option>
                                        @foreach ($grupos as $id => $nome_grupo)
                                        <option value="{{ $id }}" {{ old('grupo_empresarial') == $id ? 'selected' : '' }}>{{ $nome_grupo }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 ">

                                </div>

                                <div class="col-lg-3 ">
                                    <label for="data_contrato" class="form-label"><b>13 </b>- Data do Contrato</label>
                                    <input id="data_contrato" type="date"
                                        class="form-control @error('data_contrato') is-invalid @enderror"
                                        name="data_contrato"
                                        value="{{ old('data_contrato') }}">
                                    @error('data_contrato')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <!-- fica em duas linha EMPRESA E RAZÃO SOCIAL -->

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="nome_fantasia" class="form-label "><b>2 </b>- Nome De Fantasia</label>
                                    <input id="nome_fantasia" type="text" oninput="capitalizeInput(this)"
                                        class="form-control @error('nome_fantasia') is-invalid @enderror "
                                        name="nome_fantasia" value="{{ old('nome_fantasia') }}" required autofocus>
                                    @error('nome_fantasia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="razao_social" class="form-label"><b>3 </b>- Razão Social</label>
                                    <input id="razao_social" type="text" oninput="capitalizeInput(this)"
                                        class="form-control @error('razao_social') is-invalid @enderror"
                                        name="razao_social" value="{{ old('razao_social') }}" required>
                                    @error('razao_social')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>


                            <!-- Fique em duas linhas CPF/CNPJ e EMAIL -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="codigo_fiscal" class="form-label"><b>5 </b>- Código Fiscal (CNPJ ou CPF)</label>
                                    <input id="codigo_fiscal" type="text"
                                        class="form-control @error('codigo_fiscal') is-invalid @enderror"
                                        name="codigo_fiscal" value="{{ old('codigo_fiscal') }}" required>
                                    @error('codigo_fiscal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col">
                                    <label for="email_contato" class="form-label"><b>8 </b>- Email de Contato</label>
                                    <input id="email_contato" type="email"
                                        class="form-control @error('email_contato') is-invalid @enderror"
                                        name="email_contato" value="{{ old('email_contato') }}">
                                    @error('email_contato')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label for="grupo_classificacao" class="form-label"><b>6 </b>- Classificação</label>
                                    <select id="grupo_classificacao"
                                        class="form-select form-control @error('grupo_classificacao') is-invalid @enderror"
                                        name="grupo_classificacao" required>
                                        <option value="" disabled {{ old('grupo_classificacao') ? '' : 'selected' }}>Selecione</option>
                                        <option value="I" {{ old('grupo_classificacao') == 'I' ? 'selected' : '' }}>I</option>
                                        <option value="II" {{ old('grupo_classificacao') == 'II' ? 'selected' : '' }}>II</option>
                                    </select>
                                    @error('grupo_classificacao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-3 ">

                                </div>

                                <div class="col-md-3">
                                    <label for="modalidade" class="form-label"><b>7 </b>- Modalidade</label>
                                    <select id="modalidade"
                                        class="form-select form-control @error('modalidade') is-invalid @enderror"
                                        name="modalidade">
                                        <option value="" disabled selected>Selecione</option>
                                        <option value="PRIME">PRIME</option>
                                        <option value="POOL">POOL</option>
                                        <option value="PD SITE">PD SITE</option>
                                        <option value="NUCLEO">NUCLEO</option>
                                        <option value="NUCLEO ENG">NUCLEO ENG</option>
                                    </select>
                                    @error('modalidade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <!-- Segunda div -->
                        <div class="row mt-4 form-cadastro">

                            <!-- Fique em uma linha  -->


                            <!-- Fique em duas linhas FIF e DATA LIBERACAO DA FIF -->
                            <div class="row mt-2">

                                <div class="col-md-6">
                                    <label for="fif_status" class="form-label"><b>9 </b>- FIF Status</label>
                                    <select id="fif_status"
                                        class="form-select form-control @error('fif_status') is-invalid @enderror"
                                        name="fif_status">
                                        <option value="" disabled selected>Selecione</option>
                                        <option value="CORTESIA">CORTESIA</option>
                                        <option value="OK">OK</option>
                                        <option value="PENDENTE">PENDENTE</option>
                                        <option value="EXPIRADO">EXPIRADO</option>
                                    </select>
                                    @error('fif_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="FIF_data_liberacao" class="form-label"><b>10 </b>- Data Liberação da FIF</label>
                                    <input id="FIF_data_liberacao" type="date"
                                        class="form-control @error('FIF_data_liberacao') is-invalid @enderror"
                                        name="FIF_data_liberacao" value="{{ old('FIF_data_liberacao') }}">
                                    @error('FIF_data_liberacao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <!-- Fique em duas linhas TIPO RENOVAÇÃO e ULTIMA RENOVAÇÃO -->
                            <div class="row mt-4 mb-4">
                                <div class="col-md-6">
                                    <label for="ultima_renovacao_tipo" class="form-label"><b>11 </b>- Tipo Renovação</label>
                                    <select id="ultima_renovacao_tipo"
                                        class="form-select form-control @error('ultima_renovacao_tipo') is-invalid @enderror"
                                        name="ultima_renovacao_tipo">
                                        <option value="" disabled selected>Selecione</option>
                                        <option value="REN AUT">Renovação Automática</option>
                                        <option value="REN MAN">Renovação Manual</option>
                                    </select>
                                    @error('ultima_renovacao_tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mb-3 justify-center items-center" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label font-bold" for="bloqueio_status_financ">
                                    Tem bloqueio Financeiro?
                                </label>
                                <input class="form-check-input" type="checkbox" name="bloqueio_status_financ"
                                    id="bloqueio_status_financ">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status_produto_preco"
                                    id="status_produto_preco" checked>
                                <label class="form-check-label font-bold" for="status_produto_preco">
                                    Status Produto/Preço está ativo?
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-may-green-b">
                    <div class="flex justify-end gap-2">
                        <button type="button" value="Cancelar" data-bs-dismiss="modal" class="btn btn-danger">
                            Cancelar
                        </button>
                        <button type="submit" value="Cadastrar" class="btn btn-success border-1 border-black">
                            Cadastrar Empresa
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function formatarCpfCnpj(value) {
        value = value.replace(/\D/g, ""); // remove tudo que não é número

        if (value.length <= 11) { // CPF
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        } else { // CNPJ
            value = value.replace(/^(\d{2})(\d)/, "$1.$2");
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
            value = value.replace(/(\d{4})(\d)/, "$1-$2");
        }

        return value;
    }

    document.getElementById("codigo_fiscal").addEventListener("input", function() {
        this.value = formatarCpfCnpj(this.value);
    });
</script>
@endpush
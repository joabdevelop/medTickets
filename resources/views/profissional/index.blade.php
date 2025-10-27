<x-app-layout title="profissionais">


    <section class="container-section">
        <div class="container-list">
            <h1>Lista de Profissionais</h1>

            <form method="GET" action="{{ route('profissional.index') }}" class="input-group w-25">

                <input
                    type="search"
                    name="search"
                    id="search"
                    value="{{ old('search') ?? request('search') }}"
                    class="form-control rounded-start"
                    placeholder="Buscar..."
                    aria-label="Buscar">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">search</i>
                </button>
            </form>

            <!-- Button trigger modal -->

            <button
                type="button"
                class=" btn btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#createProfissionalModal"
                title="Incluir">
                Adicionar
                <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">group_add</i>
            </button>
        </div>
    </section>
    <section class="table-section">
        <div class="table-list">

            <!-- Alert Messages -->
            @include('components.alertas')

            <table class="table table-hover cursor-pointer table-responsive  ">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nome do Profissional</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Grupo</th>
                        <th>Setor</th>
                        <th>Tipo de Usuário</th>
                        <th>Tipo de Acesso</th>
                        <th>Ultimo Acesso</th>
                        <th>Data da criação</th>
                        <!-- Action Buttons Modal -->
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($profissionais as $profissional)
                    <tr>
                        <td>
                            @if ($profissional->profissional_ativo)
                            <span class="badge bg-success p-2 text-uppercase h6-font-size">Ativo</span>
                            @else
                            <span class="badge bg-danger p-2 text-uppercase h6-font-size">Inativo</span>
                            @endif
                        </td>
                        <td>
                            {{ $profissional->nome }}
                        </td>
                        <td style="text-transform: lowercase;">
                            {{ $profissional->user->email }}
                        </td>
                        <td>
                            {{ preg_replace('/(\\d{2})(\\d{4,5})(\\d{4})/', '($1) $2-$3', $profissional->telefone) }}
                        </td>
                        <td>
                            {{ $profissional->grupo->nome_grupo }}
                        </td>
                        <td>
                            {{ $profissional->departamento->nome }}
                        </td>
                        <td>
                            {{ $profissional->tipo_usuario == 1 ? 'Funcionário' : 'Cliente' }}
                        </td>
                        <td>
                            {{ $profissional->tipo_acesso }}
                        </td>
                        <td>
                            {{ $profissional->user->ultimo_acesso ? $profissional->user->ultimo_acesso->format('d/m/Y H:i') : 'Nunca acessado' }}
                        </td>
                        <td>
                            {{ $profissional->created_at->format('d/m/Y') }}
                        </td>

                        <td>
                            <!-- Action Buttons -->

                            <div class="d-flex  gap-2">

                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Alterar -->
                                    <a href="#" class="edit"
                                        data-id="{{ $profissional->id }}"
                                        data-nome="{{ $profissional->nome }}"
                                        data-email="{{ $profissional->user->email }}"
                                        data-telefone="{{ preg_replace('/(\\d{2})(\\d{4,5})(\\d{4})/', '($1) $2-$3', $profissional->telefone) }}"
                                        data-tipo_usuario="{{ $profissional->tipo_usuario }}"
                                        data-grupo="{{ $profissional->grupo_id }}"
                                        data-departamento="{{ $profissional->departamento_id }}"
                                        data-tipo_acesso="{{ $profissional->tipo_acesso }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateProfissionalModal">
                                        <i class="material-icons" data-bs-toggle="tooltip" title="Alterar">&#xE254;</i>
                                    </a>
                                </div>
                                <div class="form-switch">
                                    <!-- Botão Ativar/Inativar -->
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        data-id="{{ $profissional->id }}"
                                        data-nome="{{ $profissional->nome }}"
                                        data-status="{{ $profissional->profissional_ativo }}"
                                        data-bs-toggle="tooltip" title="Ativar/Inativar Profissional"
                                        data-bs-target="#statusToggleProfissionalModal"
                                        role="switch"
                                        @if($profissional->profissional_ativo) checked @endif>
                                </div>

                            </div>

                        </td>
                        @empty
                        <td colspan="10" class="text-center font-weight-bold text-danger fs-4 p-5">
                            Nenhum profissional encontrado.
                        </td>
                    </tr>
                    @endforelse


                </tbody>
            </table>
            <div class="clearfix">
                {{ $profissionais->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
    <!-- Modals -->
    @include('profissional.createModal')
    @include('profissional.updateModal')
    @include('profissional.statusModal')

    @push('scripts')
    <script>
        // PARA PREENCHER OS DADOS NO MODAL DE UPDATE
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            $('#update_id').val($(this).data('id'));
            $('#update_nome').val($(this).data('nome'));
            $('#update_email').val($(this).data('email'));
            $('#update_telefone').val($(this).data('telefone'));
            $('#update_tipo_usuario').val($(this).data('tipo_usuario'));
            $('#update_grupo').val($(this).data('grupo'));
            $('#update_departamento').val($(this).data('departamento'));
            $('#update_tipo_acesso').val($(this).data('tipo_acesso'));
            // Se quiser alterar o action do form dinamicamente:
            const id = $(this).data('id');
            let action = "{{ route('profissional.update', 0) }}";
            action = action.replace('/0', '/' + $(this).data('id'));
            $('#updateProfissionalModal form').attr('action', action);

            $('#updateProfissionalModal').on('shown.bs.modal', function() {
                $('#update_nome').trigger('focus');
            });
        });

        // PARA PREENCHER OS DADOS NO MODAL DE DELETE
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            $('#delete_id').val($(this).data('id'));
            $('#delete_nome').val($(this).data('nome'));
            $('#delete_status').val($(this).data('status'));
            // Se quiser alterar o action do form dinamicamente:
            let action = "{{ route('profissional.destroy', 0) }}";
            action = action.replace('/0', '/' + $(this).data('id'));
            $('#deleteProfissionalModal form').attr('action', action);
        });

        $(document).on('change', '.status-toggle', function(e) {
            e.preventDefault();
            window.toggleCheckbox = this;
            let id = $(this).data('id');
            let nome = $(this).data('nome');
            let status = $(this).data('status');

            // Definindo a action do form
            let route = "{{ route('profissional.toggle', 0) }}";
            let actionUrl = route.replace('/0', '/' + id);
            $('#statusToggleProfissionalModal form').attr('action', actionUrl);

            $('#statusToggleProfissionalModal').modal('show');

            if (window.toggleCheckbox) {
                // Inverte o estado do checkbox
                window.toggleCheckbox.checked = !window.toggleCheckbox.checked;
            }
            $('#deleteProfissionalModal').modal('hide');
        });

    </script>
    @endpush

</x-app-layout>
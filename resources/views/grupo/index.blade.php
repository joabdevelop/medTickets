<x-app-layout title="Grupos">

    <body>
        <section class="container-section">
            <div class="container-list">
                <h1>Lista de Grupo</h1>

                <form method="GET" action="{{ route('grupo.index') }}" class="input-group w-25">

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
                    data-bs-target="#createGrupoModal"
                    title="Incluir">
                    Adicionar
                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">group_add</i>
                </button>
            </div>
        </section>
        <section class="table-section">
            <div class="table-list">

                <!-- Alertas de sucesso ou erro -->
                @include('components.alertas')

                <table class="table table-hover cursor-pointer table-responsive">
                    <thead class="w-100">
                        <tr class="d-flex justify-content-between">
                            <th class="col text-start">Nome do Grupo</th>
                            <th class="col text-center">Relacionamento</th>
                            <th class="col text-center">Data da criação</th>
                            <th class="col text-end pl-5">Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grupos as $grupo)
                        <tr class="d-flex justify-content-between ">
                            <td class="col text-start d-flex align-items-center">{{ $grupo->nome_grupo }}</td>
                            <td class="col text-center d-flex justify-content-center align-items-center">{{ $grupo->profissional->nome }}</td>
                            <td class="col text-center d-flex justify-content-center align-items-center">{{ $grupo->created_at->format('d/m/Y') }}</td>
                            <td class="col align-items-end d-flex justify-content-end">

                                <!-- Action Buttons -->

                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Alterar -->
                                    <a href="#"
                                        class="edit"
                                        data-id="{{ $grupo->id }}"
                                        data-nome="{{ $grupo->nome_grupo }}"
                                        data-relacionamento_id="{{$grupo->relacionamento_id}}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateGrupoModal">
                                        <i class="material-icons " data-bs-toggle="tooltip" title="Alterar">&#xE254;</i>
                                    </a>
                                </div>

                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Excluir -->
                                    <a href="#" class="delet"
                                        data-id="{{ $grupo->id }}"
                                        data-nome="{{ $grupo->nome_grupo }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteGrupoModal">
                                        <i class="material-icons text-danger" data-bs-toggle="tooltip" title="Excluir">&#xE872;</i>
                                    </a>
                                </div>

                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Visualizar Empresas -->
                                    <a href="#" class="visualizar-empresas"
                                        data-id="{{ $grupo->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#visualizarEmpresasModal">
                                        <i class="material-icons text-success" title="Visualizar Empresas">search</i>
                                    </a>
                                </div>

                            </td>
                        </tr>

                        @empty
                        <td colspan="8" class="text-center">Nenhum grupo encontrado.</td>

                        @endforelse
                    </tbody>
                </table>
                <div class="clearfix">
                    {{ $grupos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
        <!-- Modals -->
        @include('grupo.createModal')
        @include('grupo.updateModal')
        @include('grupo.deleteModal')
        @include('grupo.VisualisarEmpresasModal')
    </body>

    @push('scripts')
    <script>
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            $('#update_id').val($(this).data('id'));
            $('#update_nome').val($(this).data('nome'));
            $('#update_relacionamento').val($(this).data('relacionamento_id'));
            // Se quiser alterar o action do form dinamicamente:
            let action = "{{ route('grupo.update', ':id') }}";
            action = action.replace(':id', $(this).data('id'));
            $('#updateGrupoModal form').attr('action', action);

            $('#updateGrupoModal').on('shown.bs.modal', function() {
                $('#update_nome').trigger('focus');
            });
        });
        $(document).on('click', '.delet', function(e) {
            e.preventDefault();
            $('#delete_id').val($(this).data('id'));
            $('#delete_nome').val($(this).data('nome'));
            // Se quiser alterar o action do form dinamicamente:
            let action = "{{ route('grupo.destroy', ':id') }}";
            action = action.replace(':id', $(this).data('id'));
            $('#deleteGrupoModal form').attr('action', action);
        });

        $(document).on('click', '.visualizar-empresas', function(e) {
            e.preventDefault();
            var grupoId = $(this).data('id');
            // Exemplo usando fetch, pode usar $.ajax também
            fetch('/grupos/' + grupoId + '/empresas')
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    if (data.length) {
                        data.forEach(function(empresa) {
                            html += `<tr><td>${empresa.razao_social}</td></tr>`;
                        });
                    } else {
                        html = '<tr><td colspan="8" class="text-center">Nenhuma Empresa encontrada.</td></tr>';
                    }
                    $('#empresas-list').html(html);
                });
        });
    </script>
    @endpush
</x-app-layout>
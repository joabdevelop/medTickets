<x-app-layout title="Tipos de Serviço">
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @endpush
    <body>
        <!-- List Section -->
        <section class="container-section">
            <div class="container-list">
                <h1>Tipos de Serviços</h1>

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
                    data-bs-target="#createTipoServicoModal"
                    title="Incluir">
                    Adicionar
                   <i class="bi bi-folder-plus"></i>
                </button>
            </div>
        </section>
        <!-- Table Section -->
        <section class="table-section">
            <div class="table-list">

                <!-- Alertas de sucesso ou erro -->
                @include('components.alertas')

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome do Serviço</th>
                            <th>Prioridade</th>
                            <th>Acordo de nivel de serviço - SLA</th>
                            <th>Executado por</th>
                            <th>Data de Cadastro</th>
                            <th>Data de Alteração</th>

                            <!-- Action Buttons Modal -->
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tipo_servicos as $tipo_servico)
                        <tr>
                            <td>{{ $tipo_servico->descricao_servico }}</td>
                            <td>{{ $tipo_servico->prioridade }}</td>
                            <td>{{ $tipo_servico->sla }}</td>
                            <td>{{ $tipo_servico->departamento->nome }}</td>
                            <td>{{ $tipo_servico->created_at->format('d/m/Y') }}</td>
                            <td>{{ $tipo_servico->updated_at->format('d/m/Y') }}</td>
                            <td>

                                <!-- Action Buttons -->

                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Alterar -->
                                    <a href="#" class="edit"
                                        data-id="{{ $tipo_servico->id }}"
                                        data-nome="{{ $tipo_servico->descricao_servico }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateTipoServicoModal">
                                        <i class="material-icons" data-bs-toggle="tooltip" title="Alterar">&#xE254;</i>
                                    </a>
                                </div>

                                <div class="btn-group btn-group-sm">
                                    <!-- Botão Excluir -->
                                    <a href="#" class="delet"
                                        data-id="{{ $tipo_servico->id }}"
                                        data-nome="{{ $tipo_servico->descricao_servico }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteTipoServicoModal">
                                        <i class="material-icons" data-bs-toggle="tooltip" title="Excluir">&#xE872;</i>
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
                    {{ $tipo_servicos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
        <!-- Modals -->
        @include('tipoServico.createModal')
        @include('tipoServico.updateModal')
        @include('tipoServico.deleteModal')
    </body>

    @push('scripts')
    <script>
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            $('#update_id').val($(this).data('id'));
            $('#update_nome').val($(this).data('nome'));
            // Se quiser alterar o action do form dinamicamente:
            let action = "{{ route('tipo_servico.update', ':id') }}";
            action = action.replace(':id', $(this).data('id'));
            $('#updateTipoServicoModal form').attr('action', action);

            $('#updateTipoServicoModal').on('shown.bs.modal', function() {
                $('#update_nome').trigger('focus');
            });
        });
        $(document).on('click', '.delet', function(e) {
            e.preventDefault();
            $('#delete_id').val($(this).data('id'));
            $('#delete_nome').val($(this).data('nome'));
            // Se quiser alterar o action do form dinamicamente:
            let action = "{{ route('tipo_servico.destroy', ':id') }}";
            action = action.replace(':id', $(this).data('id'));
            $('#deleteTipoServicoModal form').attr('action', action);
        });
    </script>
    @endpush

</x-app-layout>
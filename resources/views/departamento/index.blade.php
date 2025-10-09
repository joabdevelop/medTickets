<x-app-layout title="Departamentos">

    <body>
        <section class="container-section">
            <div class="container-list">
                <h1>Lista de Departamentos</h1>

                <form class="input-group w-25">
                    <input
                        type="search"
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
                    data-bs-target="#createDepartamentoModal"
                    title="Incluir">
                    Adicionar
                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">domain_add</i>
                </button>
            </div>
        </section>

        <!-- Tabela de Departamentos -->
        <section class="table-section">
            <div class="table-list">

                <!-- Alertas de sucesso ou erro -->
                @include('components.alertas')

                <table class="table table-hover cursor-pointer table-responsive">
                    <thead class="w-100">
                        <tr class="d-flex justify-content-between">
                            <th class="col text-start">Nome do Departamento</th>
                            <th class="col text-center">Sigla do Departamento</th>
                            <th class="col text-center">Data da criação</th>
                            <th class="col text-end pl-5">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departamentos as $departamento)
                        <tr class="d-flex justify-content-between ">
                            <td class="col text-start d-flex align-items-center">{{ $departamento->nome }}</td>
                            <td class="col text-center d-flex justify-content-center align-items-center">{{ $departamento->sigla_depto }}</td>
                            <td class="col text-center d-flex justify-content-center align-items-center">{{ $departamento->created_at->format('d/m/Y') }}</td>
                            <td class="col align-items-end d-flex justify-content-end">
                                <!-- Botão Alterar -->
                                <button
                                    type="button"
                                    class="btn btn-outline-success edit "
                                    data-id="{{ $departamento->id }}"
                                    data-nome="{{ $departamento->nome}}"
                                    data-sigla="{{ $departamento->sigla_depto}}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#updateDepartamentoModal">
                                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">edit_note</i>
                                </button>

                            </td>
                        </tr>
                        @empty
                        <td colspan="8" class="text-center">Nenhum departamento encontrado.</td>
                        @endforelse
                    </tbody>
                </table>

                <div class="clearfix">
                    {{ $departamentos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>

        <!-- Modals -->
        @include('departamento.createModal')
        @include('departamento.updateModal')
    </body>

    @push('scripts')
     <script>
         $(document).on('click', '.edit', function(e) {
             e.preventDefault();
             $('#update_id').val($(this).data('id'));
             $('#update_nome').val($(this).data('nome'));
             $('#update_sigla').val($(this).data('sigla'));
             // Se quiser alterar o action do form dinamicamente:
             let action = "{{ route('departamento.update', ':id') }}";
             action = action.replace(':id', $(this).data('id'));
             $('#updateDepartamentoModal form').attr('action', action);

             $('#updateDepartamentoModal').on('shown.bs.modal', function() {
                 $('#update_nome').trigger('focus');
             });

             $('#updateDepartamentoModal').on('hidden.bs.modal', function() {
                 $('#update_nome').val('');
                 $('#update_sigla').val('');
             });
         });
         $(document).on('click', '.delet', function(e) {
             e.preventDefault();
             $('#delete_id').val($(this).data('id'));
             $('#delete_nome').val($(this).data('nome'));
             // Se quiser alterar o action do form dinamicamente:
             let action = "{{ route('departamento.destroy', ':id') }}";
             action = action.replace(':id', $(this).data('id'));
             $('#deleteDepartamentoModal form').attr('action', action);
         });
     </script>
    @endpush

 </x-app-layout>
<x-app-layout title="Usuários">

    <body>

        <section class="container-section">
            <div class="container-list">

                <h1>Lista de Usuarios</h1>

                <form class="input-group w-25">
                    <input
                        type="search"
                        class="form-control rounded-start"
                        placeholder="Buscar..."
                        aria-label="Buscar">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class=" material-icons" data-bs-toggle="tooltip" title="Incluir">search</i>
                    </button>
                </form>

                <!-- Button trigger modal -->

                <button
                    type="button"
                    class=" btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createUserModal"
                    title="Incluir">
                    Adicionar
                    <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">group_add</i>
                </button>
            </div>
        </section>
        <!-- Espaçamento entre seções -->
        <section class="table-section">
            <div class="table-list">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ultimo Acesso</th>
                            <th>Cadastrado em</th>
                            <th>Ações</th>
                            <th>Bloqueado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="{{ $user->user_bloqueado ? 'table-danger' : '' }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ $user->ultimo_acesso?->format('d/m/Y H:i') ?? 'Sem Acesso' }}
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td><button>View</button></td>
                            <td>{{ $user->user_bloqueado ? 'Sim' : 'Nao' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </section>
        <!-- Create Modal CREATE USERMODAL HTML -->
        @include('user.createModal')
    </body>
</x-app-layout>
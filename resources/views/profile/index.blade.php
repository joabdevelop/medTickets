<x-app-layout title="Usuários">

    <body>
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
    </body>
</x-app-layout>
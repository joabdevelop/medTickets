<x-app-layout title="Dashboard">
    <div class="card-hero py-5 mx-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Um texto qualquer
        </h2>
    </div>

    <section class="container-section">
        <div class="container-list">
            <h1>Lista de Departamentos</h1>


            <div>
                <!-- Filtar por Numero do tickets, status e data -->
                <form method="GET" action="{{ route('ticket.index') }}"
                    class="row g-2 d-flex align-items-center justify-content-center form-floating form-cadastro form-search">
                    <div class="input-group">
                        <!-- Campo de busca -->
                        <div class="col-md-4 form-floating filtro-campo" id="campo-search">
                            <input type="search" name="search" id="search"
                                value="{{ old('search') ?? request('search') }}" class="form-control rounded-start"
                                placeholder="Digite o numero" aria-label="Buscar">
                            <label for="search" class="form-label">numero do ticket</label>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3 form-floating filtro-campo" id="campo-status">
                            <select name="select_statusFinal" id="select_statusFinal" class="form-select form-control">
                                <option value="Todos" @selected(request('select_statusFinal') == 'Todos' || !request('select_statusFinal'))>
                                    Todos
                                </option>
                            </select>
                            <label for="select_statusFinal" class="form-label">Status</label>
                        </div>
                        <button type="submit" id="submit_status_filter" class="d-none"></button>

                        <!-- Data -->
                        <div class="col-md-3 form-floating filtro-campo" id="campo-data">
                            <input type="date" class="form-control" id="data_ticket" name="data_ticket">
                            <label for="data_ticket" class="form-label">Data</label>
                        </div>
                        <button type="submit" class="btn btn-outline-secondary">Filtrar</button>
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" data-target="campo-search">Numero do ticket</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" data-target="campo-status">Status do ticket</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" data-target="campo-data">Data do ticket</a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Tabela de Departamentos -->
    <section class="table-section">
        <div class="table-list">


            <table class="table table-hover cursor-pointer table-responsive">
                <thead class="w-100">
                    <tr class="d-flex justify-content-between">
                        <th class="col text-start">Nome do Departamento</th>
                        <th class="col text-center">Sigla do Departamento</th>
                        <th class="col text-center">Data da criação</th>
                        <th class="col text-end pl-5">Alterar</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </section>
    @push('scripts')
        <script>
            document.querySelectorAll('.dropdown-item[data-target]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Esconde todos os campos de filtro
                    document.querySelectorAll('.filtro-campo').forEach(f => f.style.display = 'none');
                    // Mostra o campo correspondente
                    const campoId = this.getAttribute('data-target');
                    document.getElementById(campoId).style.display = 'block';
                });
            });

            // Inicialmente, opcional: mostra todos ou só um.
            document.querySelectorAll('.filtro-campo').forEach(f => f.style.display = 'none');
            // Ou para mostrar o primeiro por padrão:
            document.getElementById('campo-search').style.display = 'block';
        </script>
    @endpush
</x-app-layout>

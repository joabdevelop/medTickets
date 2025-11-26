@props([
    'title' => 'Tickets - Fila de Solicitações',
    'route',
    'statusList' => [], // lista de status vinda do controller
    'defaultFilter' => 'search',
])

@php
    // Detecta qual filtro está ativo
    $filtroAtivo = 'campo-search';

    if (request()->filled('search')) {
        $filtroAtivo = 'campo-search';
    } elseif (request()->filled('select_statusFinal') && request('select_statusFinal') !== 'Todos') {
        $filtroAtivo = 'campo-status';
    } elseif (request()->filled('data_ticket')) {
        $filtroAtivo = 'campo-data';
    }
@endphp

<section class="container-listas p-3">
    <div class="container-fluid m-0">

        <!-- Linha: Título à esquerda / Filtros à direita -->
        <div class="row align-items-center justify-content-between mb-3">

            <!-- Título -->
            <div class="col-12 col-md-6 d-flex align-items-end ">
                <h1 class="h3 mb-0">{{ $title }}</h1>
            </div>

            <!-- Formulário de filtros -->
            <div class="col-12 col-md-4 d-flex mt-3 mt-md-0">

                <form method="GET" action="{{ $route }}" class="row g-2 w-100 ">

                    <!-- Campo Número -->
                    <div class="col-12 col-md-6 filtro-campo" id="campo-search"
                        style="{{ $filtroAtivo !== 'campo-search' ? 'display:none;' : '' }}">
                        <label for="search" class="form-label text-transparent m-0">Número do ticket</label>
                        <input type="search" name="search" id="search"
                            value="{{ old('search') ?? request('search') }}"
                            class="form-control" placeholder="Digite o número">
                    </div>

                    <!-- Campo Status -->
                    <div class="col-12 col-md-6 filtro-campo" id="campo-status"
                        style="{{ $filtroAtivo !== 'campo-status' ? 'display:none;' : '' }}">
                        <label for="select_statusFinal" class="form-label text-transparent m-0">Status</label>
                        <select name="select_statusFinal" id="select_statusFinal" class="form-select">
                            <option value="Todos" @selected(request('select_statusFinal') == 'Todos' || !request('select_statusFinal'))>
                                Todos
                            </option>

                            @if (isset($statusList))
                                @foreach ($statusList as $status)
                                    <option value="{{ $status->value }}"
                                        @selected(old('select_statusFinal', request('select_statusFinal')) == $status->value)>
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Campo Data -->
                    <div class="col-12 col-md-6 filtro-campo" id="campo-data"
                        style="{{ $filtroAtivo !== 'campo-data' ? 'display:none;' : '' }}">
                        <label for="data_ticket" class="form-label text-transparent m-0">Data</label>
                        <input type="date" class="form-control" id="data_ticket" name="data_ticket"
                            value="{{ old('data_ticket', request('data_ticket')) }}">
                    </div>

                    <!-- Dropdown + Botão --> 
                    <div class="col-12 col-md-6 d-flex gap-2 align-items-end">

                        <!-- Dropdown -->
                        <div class="dropdown flex-grow-1 btn-group">
                            <button class="btn btn-outline-primary w-100 dropdown-toggle"
                                type="button" data-bs-toggle="dropdown">

                                <span id="filtro-selecionado-texto">
                                    @if ($filtroAtivo === 'campo-search')
                                        Número
                                    @elseif ($filtroAtivo === 'campo-status')
                                        Status
                                    @elseif ($filtroAtivo === 'campo-data')
                                        Data
                                    @else
                                        Filtrar por
                                    @endif
                                </span>

                            </button>

                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="#" data-target="campo-search">Número do ticket</a></li>
                                <li><hr class="dropdown-divider"></li>

                                <li><a class="dropdown-item" href="#" data-target="campo-status">Status do ticket</a></li>
                                <li><hr class="dropdown-divider"></li>

                                <li><a class="dropdown-item" href="#" data-target="campo-data">Data do ticket</a></li>
                            </ul>
                        </div>

                        <!-- Botão submit -->
                        <button type="submit" class="btn btn-success btn-sm">
                            Buscar
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</section>


<script>
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Oculta todos os campos
            document.querySelectorAll('.filtro-campo').forEach(campo => campo.style.display = 'none');

            // Mostra o selecionado
            const alvo = this.getAttribute('data-target');
            document.getElementById(alvo).style.display = 'block';

            // Atualiza o texto do dropdown
            document.getElementById('filtro-selecionado-texto').innerText = this.innerText;
        });
        // 3. NOVA LÓGICA: Estado inicial da visibilidade dos campos após o carregamento (Refresh)

        // Oculta todos os campos primeiro
        document.querySelectorAll('.filtro-campo').forEach(f => f.style.display = 'none');

        // Define o campo ativo com base na variável PHP lida na inicialização
        const filtroAtivoId = '{{ $filtroAtivo }}';

        if (filtroAtivoId && document.getElementById(filtroAtivoId)) {
            document.getElementById(filtroAtivoId).style.display = 'block';
        }

    });
</script>

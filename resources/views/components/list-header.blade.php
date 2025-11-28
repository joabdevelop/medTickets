@props([
    'title',
    'route',
    'placeholder' => 'Buscar...',
    'modal',
    'icon' => 'bi bi-plus-lg',
    'rounded' => true,  {{-- botão padrão será redondo --}}
])

<section class="container-section">

    <div class="container-list p-3">

        <div class="section-header">

            <!-- Título -->
            <div>
                <h1 class="section-title">{{ $title }}</h1>
            </div>

            <!-- Controles -->
            <div class="section-controls">

                <!-- Campo de busca -->
                <form method="GET" action="{{ $route }}" class="input-group section-search-group" role="search">

                    <input
                        type="search"
                        name="search"
                        value="{{ old('search') ?? request('search') }}"
                        class="form-control"
                        placeholder="{{ $placeholder }}"
                        aria-label="Buscar"
                    >

                    <button class="btn btn-outline-primary" type="submit">
                       <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Botão (redondo ou padrão) -->
                <button
                    type="button"
                    class="btn {{ $rounded ? 'btn-success btn-round' : 'btn-success btn-round' }}"
                    data-bs-toggle="modal"
                    data-bs-target="#{{ $modal }}"
                >
                    <i class="{{ $icon }}"></i>
                </button>

            </div>

        </div>

    </div>

</section>

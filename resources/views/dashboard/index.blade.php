<x-app-layout title="Processar Métricas Consolidadas">

    <section class="container-section d-flex justify-content-center align-items-center" style="height: 70vh;">

        <!-- Spinner central -->
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
            <p class="mt-3 fs-4">Processando métricas, por favor aguarde...</p>
        </div>

        <!-- Form que será auto-submetido -->
        <form id="processForm" method="POST" action="{{ route('metricas.consolidadas') }}" class="d-none">
            @csrf
        </form>

    </section>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Aguarda 300ms só para mostrar o spinner antes do envio
                setTimeout(() => {
                    document.getElementById('processForm').submit();
                }, 300);
            });
        </script>
    @endpush

</x-app-layout>

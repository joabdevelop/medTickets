<x-app-layout title="Perfil do Usuário">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalhes do Perfil</h3>
            </div>
            <div class="card-body">
                @if(auth()->check())
                    {{-- Usando classes do Bootstrap 5 para layout de formulário --}}
                    <div class="row mb-3"> {{-- mb-3 para espaçamento --}}
                        <label class="col-sm-4 col-form-label">Nome:</label>
                        <div class="col-sm-8">
                            {{-- Bootstrap 5 recomenda form-control-plaintext --}}
                            <p class="form-control-plaintext">{{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Email:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Departamento:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ auth()->user()->department ?? 'Não Informado' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Cargo (Role):</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ auth()->user()->role ?? 'Não Informado' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Data de Criação:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ auth()->user()->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Último Acesso:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">
                                {{ auth()->user()->last_activity ? auth()->user()->last_activity->format('d/m/Y H:i:s') : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-4"> {{-- hr com margem do Bootstrap 5 --}}

                    <div class="d-flex justify-content-end">
                        <a href="{{-- route('profile.edit') --}}" class="btn btn-primary">
                            <ion-icon name="create-outline" style="vertical-align: middle;"></ion-icon> Editar Perfil
                        </a>
                    </div>
                @else
                    <p class="text-center">Nenhum usuário logado.</p>
                @endif
            </div>
        </div>

</x-app.layouts>
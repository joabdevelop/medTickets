<!-- Create Modal CREATE USERMODAL HTML -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <div class="col-md-6">
                        <h4 class="modal-title">Criar Usuário</h4>
                    </div>
                    <div class="col-md-6">
                        <h1 id="message"></h1>
                    </div>
                </div>

                {{-- Nome --}}
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Nome completo" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                    @error('name')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirmar senha --}}
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirme a senha">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password_confirmation')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botão --}}
                <button type="submit" class="btn btn-success btn-block">
                    <span class="fas fa-user-plus mr-2"></span> Registrar
                </button>
            </form>
        </div>
    </div>
</div>
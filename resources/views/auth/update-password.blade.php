<x-app-layout title="Trocar Senha">

    {{-- filepath: resources/views/profile/update-password.blade.php --}}

    <div class="form-section">

        <div class="form-wrapper">
            <h2 class="card-header">Trocar Senha</h2>

            @if (session('status') === 'password-updated')
            <div class="alert alert-success mb-4">
                Senha alterada com sucesso!
            </div>
            @endif

            <form method="POST" class="form" action="{{ route('profile.password.update') }}">
                @csrf

                <div class="mb-2">
                    <label for="current_password" class="form-row ">Senha atual</label>
                    <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="form-in">
                    @error('current_password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="password" class="form-row ">Nova senha</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="form-in ">
                    @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="password_confirmation" class="form-row ">Confirme a nova senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-in">
                </div>

                <button type="submit" class="createBtn2">
                    Atualizar Senha
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
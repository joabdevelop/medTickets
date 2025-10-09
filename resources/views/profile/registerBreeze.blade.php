<x-app-layout title="Registrar Usuário">
    <div class="flex justify-center mt-10 px-4"> {{-- flex e justify-center para centralizar, mt-10 para margem superior, px-4 para padding horizontal --}}
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg overflow-hidden"> {{-- w-full max-w-md para largura responsiva, shadow-lg para sombra, rounded-lg para bordas arredondadas --}}
            <div class="bg-indigo-700 text-white p-4"> {{-- card-header equivalente --}}
                <h3 class="text-xl font-semibold">Registro de Usuário</h3> {{-- card-title equivalente --}}
            </div>
            <div class="p-6"> {{-- card-body equivalente --}}
                <form action="{{ route('profile.store') }}" method="POST">
                    @csrf

                    {{-- Nome --}}
                    <div class="mb-4"> {{-- input-group mb-3 equivalente --}}
                        <label for="name" class="sr-only">Nome completo</label> {{-- sr-only para acessibilidade --}}
                        <div class="relative flex items-center">
                            <input type="text" name="name"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('name') }}" placeholder="Nome completo" autofocus>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <ion-icon name="person-outline"></ion-icon> {{-- Ícone Ionicon --}}
                            </div>
                        </div>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> {{-- invalid-feedback equivalente --}}
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <div class="relative flex items-center">
                            <input type="email" name="email"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('email') }}" placeholder="Email">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <ion-icon name="mail-outline"></ion-icon> {{-- Ícone Ionicon --}}
                            </div>
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Departamento --}}
                    <div class="mb-4">
                        <label for="department" class="sr-only">Departamento</label>
                        <div class="relative flex items-center">
                            <input type="text" name="department"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('department') ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('department') }}" placeholder="Departamento">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <ion-icon name="business-outline"></ion-icon> {{-- Ícone Ionicon para departamento --}}
                            </div>
                        </div>
                        @error('department')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Cargo (Role) --}}
                    <div class="mb-4">
                        <label for="role" class="sr-only">Cargo (Role)</label>
                        <div class="relative flex items-center">
                            <select name="role" id="role"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }}">
                                <option value="" disabled selected>Selecione um Cargo</option>
                                {{-- Exemplo de cargos - personalize conforme seus roles --}}
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Gerente</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuário Padrão</option>
                                <option value="auditor" {{ old('role') == 'auditor' ? 'selected' : '' }}>Auditor</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 pointer-events-none"> {{-- pointer-events-none para que o ícone não interfira com o select --}}
                                <ion-icon name="person-circle-outline"></ion-icon> {{-- Ícone Ionicon para cargo --}}
                            </div>
                        </div>
                        @error('role')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="mb-4">
                        <label for="password" class="sr-only">Senha</label>
                        <div class="relative flex items-center">
                            <input type="password" name="password"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Senha">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <ion-icon name="lock-closed-outline"></ion-icon> {{-- Ícone Ionicon --}}
                            </div>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirmar senha --}}
                    <div class="mb-6"> {{-- mb-6 para mais espaço antes do botão --}}
                        <label for="password_confirmation" class="sr-only">Confirme a senha</label>
                        <div class="relative flex items-center">
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Confirme a senha">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <ion-icon name="lock-closed-outline"></ion-icon> {{-- Ícone Ionicon --}}
                            </div>
                        </div>
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Botão --}}
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                        <ion-icon name="person-add-outline" class="inline-block align-middle mr-2"></ion-icon> Registrar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

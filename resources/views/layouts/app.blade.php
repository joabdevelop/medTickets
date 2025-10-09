<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ config('adminpanel.title') }}@if(!empty($title)) | {{ $title }}
        @elseif (trim($__env->yieldContent('title'))) | @yield('title')
        @endif
    </title>


    <!-- LINK DA FONTE ROBOTO (COPIADO DO GOOGLE FONTS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FIM DO LINK DA FONTE ROBOTO -->

    <!-- Styles específicos por página -->
    @stack('styles')

    <!-- JQUERY E IONICONS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- FIM DO JQUERY E IONICONS -->

    <!-- VITE CSS E JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- FIM DO VITE CSS E JS -->
</head>

<body>

    @php
    $menuItems = config('adminpanel.menu'); // carga das configurações do sidebar menu.
    @endphp
    <!-- =============== Topbar ================ -->
    <div class="topbar ">
        <!-- Grid 1 -->
        <div class="topbar-brand">
            <img src="{{ asset(config('adminpanel.logo_image')) }}" alt="Logo" class="logo-image" />
            <span class="logo-text">{{config('adminpanel.logo_name')}}</span>
        </div>

        <!-- Grid 2 -->
        <div class="topbar-controls">
            <!--
            <button class="toggle" onclick="toggle()">
                <ion-icon name="menu-outline" class="menu-icon"></ion-icon>
            </button>
            -->

            <!-- SEÇÃO DO USUÁRIO COM DROPDOWN -->
            <div class="user-dropdown-container">
                <div class="user-info">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <span class="username">{{ auth()->user()->name }}</span>
                </div>

                <div class="user-dropdown-menu">
                    <ul>
                        <li><a href="{{ route('profile.show') }}">Perfil</a></li>
                        <li><a href="{{route('profile.password.edit')}}">Trocar Senha</a></li>
                        <li class="logout-item">
                            <!-- FORMULÁRIO DE LOGOUT -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- FIM DA SEÇÃO DO USUÁRIO COM DROPDOWN -->

        </div>
    </div>

    <!-- =============== Sidebar ================ -->
    <div class="navigation scroll-auto">
        <ul class="menu">
            @foreach ($menuItems as $menuItem)
            <li class="menu-item {{ isset($menuItem['submenu']) ? 'has-submenu' : '' }}">
                {{-- Lógica para o item de menu principal --}}
                {{-- A sua lógica atual para o item principal está OK, já que ele não tem parâmetros. --}}
                <a href="{{ isset($menuItem['route_name']) ? route($menuItem['route_name']) : url($menuItem['url'] ?? '#') }}"
                    @if (isset($menuItem['target'])) target="{{ $menuItem['target'] }}" @endif>
                    <span class="icon">
                        <ion-icon name="{{ $menuItem['icon'] ?? 'menu-outline' }}"></ion-icon>
                         
                    </span>
                    <span class="title">{{ $menuItem['text'] }}</span>
                    @if (isset($menuItem['submenu']))
                    <span class="submenu-toggle-icon">
                        <ion-icon name="chevron-down-outline"></ion-icon>
                    </span>
                    @endif
                </a>

                @if (isset($menuItem['submenu']))
                <ul class="submenu">
                    @foreach ($menuItem['submenu'] as $subItem)
                    <li class="submenu-item">
                        {{-- Início da lógica modificada para sub-itens --}}
                        @php
                        $routeUrl = '#'; // Valor padrão caso não haja rota
                        if (isset($subItem['route_name'])) {
                        if (isset($subItem['route_params'])) {
                        $routeUrl = route($subItem['route_name'], $subItem['route_params']);
                        } else {
                        $routeUrl = route($subItem['route_name']);
                        }
                        } elseif (isset($subItem['url'])) {
                        $routeUrl = url($subItem['url']);
                        }
                        @endphp

                        <a href="{{ $routeUrl }}"
                            @if (isset($subItem['target'])) target="{{ $subItem['target'] }}" @endif>
                            <span class="icon">
                                <ion-icon name="{{ $subItem['icon'] ?? 'ellipsis-horizontal-outline' }}"></ion-icon>
                            </span>
                            <span class="title">{{ $subItem['text'] }}</span>
                        </a>
                        {{-- Fim da lógica modificada --}}
                    </li>
                    @endforeach
                </ul>
                @endif

            </li>

            @endforeach
        </ul>
    </div>

    <!-- =============== Main Content ================ -->
    <div class="main-content">
        {{ $slot }}
        @stack('scripts')
    </div>
</body>

</html>
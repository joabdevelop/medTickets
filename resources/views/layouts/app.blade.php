<!DOCTYPE html>
<html lang="pt_BR">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
        {{ config('adminpanel.title') }}
        @if (!empty($title))
            | {{ $title }}
        @elseif(trim($__env->yieldContent('title')))
            | @yield('title')
        @endif
    </title>

    <!-- CSS + JS compilados pelo Vite (muito mais rápido) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body>

    <!-- =============== Topbar ================ -->
    <div class="topbar">
        <div class="topbar-brand">
            <img src="{{ asset(config('adminpanel.logo_image')) }}" alt="Logo" class="logo-image" />
            <span class="logo-text">{{ config('adminpanel.logo_name') }}</span>
        </div>

        <div class="topbar-controls">

            <!-- Usuário -->
            <div class="user-dropdown-container">
                <div class="user-info">
                    <i class="bi bi-person-circle"></i>
                    <span class="username">{{ auth()->user()->name }}</span>
                </div>

                <div class="user-dropdown-menu">
                    <ul>
                        <li><a href="{{ route('profile.show') }}">Perfil</a></li>
                        <li><a href="{{ route('profile.password.edit') }}">Trocar Senha</a></li>

                        <li class="logout-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- =============== Sidebar ================ -->
    <div class="navigation scroll-auto">
        <ul class="menu">
            @foreach ($filteredMenuItems as $menuItem)
                <li class="menu-item {{ isset($menuItem['submenu']) ? 'has-submenu' : '' }}">

                    <a href="{{ isset($menuItem['route_name']) ? route($menuItem['route_name']) : url($menuItem['url'] ?? '#') }}"
                        @if (isset($menuItem['target'])) target="{{ $menuItem['target'] }}" @endif>

                        <span class="icon">
                            <i class="bi bi-{{ $menuItem['icon'] ?? 'menu-button-wide' }}"></i>
                        </span>

                        <span class="title">{{ $menuItem['text'] }}</span>

                        @if (isset($menuItem['submenu']))
                            <span class="submenu-toggle-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        @endif
                    </a>

                    @if (isset($menuItem['submenu']))
                        <ul class="submenu">
                            @foreach ($menuItem['submenu'] as $subItem)
                                <li class="submenu-item">

                                    @php
                                        $routeUrl = isset($subItem['route_name'])
                                            ? (isset($subItem['route_params'])
                                                ? route($subItem['route_name'], $subItem['route_params'])
                                                : route($subItem['route_name']))
                                            : url($subItem['url'] ?? '#');
                                    @endphp

                                    <a href="{{ $routeUrl }}"
                                        @if (isset($subItem['target'])) target="{{ $subItem['target'] }}" @endif>

                                        <span class="icon">
                                            <i class="bi bi-{{ $subItem['icon'] ?? 'dot' }}"></i>
                                        </span>

                                        <span class="title">{{ $subItem['text'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </li>
            @endforeach
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div id="main-spinner" class="main-spinner d-none">
            <div class="loader"></div>
            <span>Carregando...</span>
        </div>
        {{ $slot }}
        @stack('scripts');
    </div>
    @stack('modals');
</body>

</html>

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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- IONICONS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- FONTE ROBOTO -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @stack('styles')
</head>

<body>

    @php
        use App\Models\Profissional;

        $userId = Auth::user()->id;

        // Pega o profissional pelo user_id (não profile_id)
        $tipoAcesso = Profissional::where('user_id', $userId)->value('tipo_acesso');

        switch ($tipoAcesso) {
            case 'Cliente':
                $userProfileId = 1;
                break;

            case 'Estagiario':
                $userProfileId = 2;
                break;

            case 'Funcionario':
                $userProfileId = 3;
                break;

            case 'Gestor':
                $userProfileId = 4;
                break;

            case 'Admin':
                $userProfileId = 5;
                break;

            default:
                $userProfileId = 1;
                break;
        }

        // ====== FILTRO DO MENU ======

        $menuItems = collect(config('adminpanel.menu'));

        $filterMenu = function ($items) use (&$filterMenu, $userProfileId) {
            return $items
                ->map(function ($item) use (&$filterMenu, $userProfileId) {
                    $hasPermission = true;

                    if (isset($item['perfil'])) {
                        $hasPermission = in_array($userProfileId, $item['perfil']);
                    }

                    if (isset($item['submenu'])) {
                        $filteredSub = $filterMenu(collect($item['submenu']));

                        if ($filteredSub->isNotEmpty()) {
                            $item['submenu'] = $filteredSub->values()->all();
                            $hasPermission = true;
                        } else {
                            unset($item['submenu']);
                        }
                    }

                    return $hasPermission ? $item : null;
                })
                ->filter()
                ->values();
        };

        $filteredMenuItems = $filterMenu($menuItems);
    @endphp


    <!-- =============== Topbar ================ -->
    <div class="topbar">
        <!-- Grid 1 -->
        <div class="topbar-brand">
            <img src="{{ asset(config('adminpanel.logo_image')) }}" alt="Logo" class="logo-image" />
            <span class="logo-text">{{ config('adminpanel.logo_name') }}</span>
        </div>

        <!-- Grid 2 -->
        <div class="topbar-controls">

            <!-- Usuário -->
            <div class="user-dropdown-container">
                <div class="user-info">
                    <ion-icon name="person-circle-outline"></ion-icon>
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

                    <!-- LINK PRINCIPAL -->
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

                    <!-- SUBMENU -->
                    @if (isset($menuItem['submenu']))
                        <ul class="submenu">
                            @foreach ($menuItem['submenu'] as $subItem)
                                <li class="submenu-item">

                                    @php
                                        // Geração correta da URL do submenu
                                        if (isset($subItem['route_name'])) {
                                            $routeUrl = isset($subItem['route_params'])
                                                ? route($subItem['route_name'], $subItem['route_params'])
                                                : route($subItem['route_name']);
                                        } else {
                                            $routeUrl = url($subItem['url'] ?? '#');
                                        }
                                    @endphp

                                    <a href="{{ $routeUrl }}"
                                        @if (isset($subItem['target'])) target="{{ $subItem['target'] }}" @endif>

                                        <span class="icon">
                                            <ion-icon
                                                name="{{ $subItem['icon'] ?? 'ellipsis-horizontal-outline' }}"></ion-icon>
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

    <!-- =============== Main Content ================ -->
    <div class="main-content">
        {{ $slot }}
        @stack('scripts')
    </div>

</body>

</html>

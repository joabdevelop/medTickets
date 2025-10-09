<?php

return [
    'title' => 'MedAtende',
    'logo_name' => 'MedAtende',
    'logo_image' => 'images/logotipo.png',
    'menu' => [
        // Sidebar items:
        [
            'text' => 'Home',
            'route_name' => 'home',
            'icon' => 'home-outline',
            'icon_color' => 'red',
        ],
        [
            'text' => 'Dashboard',
            'route_name' => 'dashboard',
            'icon' => 'bar-chart-outline',
            'icon_color' => 'red',
        ],
        [
            'text' => 'Chamados',
            'icon' => 'document-text-outline',
            'submenu' => [
                [
                    'text' => 'Chamados',
                    'route_name' => 'empresa.index',
                    'icon' => 'megaphone-outline',
                ],
                [
                    'text' => 'Tipos de Serviço',
                    'route_name' => 'tipo_servico.index',
                    'icon' => 'build-outline',
                ],
            ],
        ],
        [
            'text' => 'Empresa/Grupos',
            'icon' => 'business-outline',
            'submenu' => [
                [
                    'text' => 'Empresas',
                    'route_name' => 'empresa.index',
                    'icon' => 'briefcase-outline',
                ],
                [
                    'text' => 'Grupos',
                    'route_name' => 'grupo.index',
                    'icon' => 'file-tray-stacked-outline',
                ],
            ],
        ],
        [
            'text' => 'Profissionais',
            'icon' => 'woman-outline',
            'icon_color' => 'red',
            'submenu' => [
                [
                    'text' => 'Profissionais',
                    'route_name' => 'profissional.index',
                    'icon' => 'footsteps-outline',
                ],
                [
                    'text' => 'Departamentos',
                    'route_name' => 'departamento.index',
                    'icon' => 'layers-outline',
                ],
            ],
        ],
        [
            'text' => 'Configurações',
            'icon' => 'construct-outline',
        ],
        [
            'text' => 'Sign Out',
            'route_name' => 'dashboard',
            'icon' => 'log-out-outline',
            'icon_color' => 'red',
        ],
    ],
];

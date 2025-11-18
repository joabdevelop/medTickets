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
            'perfil' => [1, 2, 3, 4, 5],
        ],
        [
            'text' => 'Dashboard',
            'icon' => 'bar-chart-outline',
            'perfil' => [4, 5],
            'submenu' => [
                [
                    'text' => 'Desempenho Operacional',
                    'route_name' => 'dashboard.operacional',
                    'icon' => 'footsteps-outline',
                    'perfil' => [4, 5],
                ],
                [
                    'text' => 'Performance de SLA',
                    'route_name' => 'dashboard.sla',
                    'icon' => 'layers-outline',
                    'perfil' => [4, 5],
                ],
                [
                    'text' => 'Desempenho de Equipe',
                    'route_name' => 'dashboard.equipe',
                    'icon' => 'layers-outline',
                    'perfil' => [4, 5],
                ],
            ],
        ],
        [
            'text' => 'Tickets',
            'route_name' => 'ticket.index',
            'icon' => 'ticket-outline',
            'icon_color' => 'red',
            'perfil' => [2, 3, 4, 5],
        ],
        [
            'text' => 'Solicitar Serviço',
            'route_name' => 'solicitaServico.index',
            'icon' => 'megaphone-outline',
            'perfil' => [1, 2, 3, 4, 5],
        ],
        [
            'text' => 'Tipos de Serviço',
            'route_name' => 'tipo_servico.index',
            'icon' => 'build-outline',
            'perfil' => [3, 4, 5],
        ],
        [
            'text' => 'Empresas',
            'route_name' => 'empresa.index',
            'icon' => 'business-outline',
            'perfil' => [2, 3, 4, 5],
        ],
        [
            'text' => 'Grupos',
            'route_name' => 'grupo.index',
            'icon' => 'file-tray-stacked-outline',
            'perfil' => [3, 4, 5],
        ],
        [
            'text' => 'Profissionais',
            'route_name' => 'profissional.index',
            'icon' => 'woman-outline',
            'perfil' => [4, 5],
        ],
        [
            'text' => 'Departamentos',
            'route_name' => 'departamento.index',
            'icon' => 'layers-outline',
            'perfil' => [4, 5],
        ],
    ],
];

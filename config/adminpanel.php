<?php

return [
    'title' => 'MedAtende',
    'logo_name' => 'MedAtende',
    'logo_image' => 'images/logotipo.png',

    'menu' => [
        [
            'text' => 'Home',
            'route_name' => 'home',
            'icon' => 'house',
            'perfil' => [1, 2, 3, 4, 5],
        ],

        [
            'text' => 'Dashboard',
            'icon' => 'bar-chart-line',
            'perfil' => [4, 5],
            'submenu' => [
                [
                    'text' => 'Desempenho Operacional',
                    'route_name' => 'dashboard.operacional',
                    'icon' => 'speedometer2',
                    'perfil' => [4, 5],
                ],

                [
                    'text' => 'Performance de SLA',
                    'route_name' => 'dashboard.sla',
                    'icon' => 'diagram-3',
                    'perfil' => [4, 5],
                ],

                [
                    'text' => 'Desempenho de Equipe',
                    'route_name' => 'dashboard.equipe',
                    'icon' => 'people',
                    'perfil' => [4, 5],
                ],
            ],
        ],

        [
            'text' => 'Tickets',
            'route_name' => 'ticket.index',
            'icon' => 'ticket-detailed',
            'perfil' => [2, 3, 4, 5],
        ],

        [
            'text' => 'Solicitar Serviço',
            'route_name' => 'solicitaServico.index',
            'icon' => 'megaphone',
            'perfil' => [1, 2, 3, 4, 5],
        ],

        [
            'text' => 'Tipos de Serviço',
            'route_name' => 'tipo_servico.index',
            'icon' => 'wrench',
            'perfil' => [3, 4, 5],
        ],

        [
            'text' => 'Empresas',
            'route_name' => 'empresa.index',
            'icon' => 'building',
            'perfil' => [2, 3, 4, 5],
        ],

        [
            'text' => 'Grupos',
            'route_name' => 'grupo.index',
            'icon' => 'layers',
            'perfil' => [3, 4, 5],
        ],

        [
            'text' => 'Profissionais',
            'route_name' => 'profissional.index',
            'icon' => 'person',
            'perfil' => [4, 5],
        ],

        [
            'text' => 'Departamentos',
            'route_name' => 'departamento.index',
            'icon' => 'layers',
            'perfil' => [4, 5],
        ],
    ],
];

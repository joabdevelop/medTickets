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
            'icon' => 'bar-chart-outline',
            'submenu' => [
                [
                    'text' => 'Desempenho Operacional',
                    'route_name' => 'dashboard.operacional',
                    'icon' => 'footsteps-outline',
                ],
                [
                    'text' => 'Performance de SLA',
                    'route_name' => 'dashboard.sla',
                    'icon' => 'layers-outline',
                ],
                [
                    'text' => 'Desempenho de Equipe',
                    'route_name' => 'dashboard.equipe',
                    'icon' => 'layers-outline',
                ],
            ],
        ],
        [
            'text' => 'Tickets',
            'route_name' => 'ticket.index',
            'icon' => 'ticket-outline',
            'icon_color' => 'red',
        ],
        [
            'text' => 'Chamados',
            'icon' => 'document-text-outline',
            'submenu' => [
                [
                    'text' => 'Solicitar Serviço',
                    'route_name' => 'solicitaServico.index',
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
    ],
];

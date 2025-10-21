<?php

namespace App\Enums;

enum TipoAcesso: string
{
    case ADMIN = 'Admin';
    case GESTOR = 'Gestor';
    case CLIENTE = 'Cliente';
    case FUNCIONARIO = 'Funcionario';
    case ESTAGIARIO = 'Estagiario';
}

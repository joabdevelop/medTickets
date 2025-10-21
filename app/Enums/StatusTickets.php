<?php

namespace App\Enums;

enum StatusTickets: string
{
    case Aberto = 'Aberto';
    case EmAndamento = 'Em Andamento';
    case Pendente = 'Pendente';
    case Devolvido = 'Devolvido';
    case Concluido = 'Concluido';
}

<?php

namespace App\Enums;

// É utilizado Nos controllers TIPOSERVICO, MODEL, INDEX, CREATE E NO UPDATE
enum Prioridad: int
{
    case Baixa = 1;
    case Media = 2;
    case Alta = 3;
    case Urgente = 4;

    /**
     * Retorna a descrição (string) do caso para exibição.
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::Baixa => 'Baixa',
            self::Media => 'Media',
            self::Alta => 'Alta',
            self::Urgente => 'Urgente',
        };
    }
}
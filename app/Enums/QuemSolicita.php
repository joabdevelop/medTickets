<?php

namespace App\Enums;

// É utilizado Nos controllers TIPOSERVICO, MODEL, INDEX, CREATE E NO UPDATE
enum QuemSolicita: int
{
    case Ambos = 0;
    case Funcionario = 1;
    case Cliente = 2;

    /**
     * Retorna a descrição (string) do caso para exibição.
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::Funcionario => 'Funcionário',
            self::Cliente => 'Cliente',
            self::Ambos => 'Equipe interna e Cliente'
        };
    }
}
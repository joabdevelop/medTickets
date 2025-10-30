<?php

namespace App\Enums;

// É utilizado Nos controllers PROFISSIONAL e no SOLICITAÇÃO DE SERVIÇOS
enum TipoUsuario: int
{
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
        };
    }
}
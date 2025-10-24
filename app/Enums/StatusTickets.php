<?php

namespace App\Enums;

enum StatusTickets: string
{
    case Aberto = 'Aberto';
    case EmAndamento = 'Em Andamento';
    case Pendente = 'Pendente';
    case Devolvido = 'Devolvido';
    case Concluido = 'Concluído';

    /**
     * Retorna a classe Bootstrap (ou cor) apropriada para cada status.
     * Pode ser usado diretamente no HTML para estilizar tags ou badges.
     *
     * @return string
     */
    public function getBootstrapClass(): string
    {
        return match ($this) {
            self::Aberto => 'bg-info text-white', // Azul claro
            self::EmAndamento => 'bg-warning text-dark', // Amarelo/Laranja (requer atenção)
            self::Pendente => 'bg-secondary text-white', // Cinza/Laranja (depende da sua definição de secondary)
            self::Devolvido => 'bg-danger text-white', // Vermelho (problema, cancelado ou requer ação imediata)
            self::Concluido => 'bg-success text-white', // Verde (sucesso, finalizado)
        };
    }
}

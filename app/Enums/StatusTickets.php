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
            self::Aberto => 'bg-info text-whiteborder border border-black', // Azul claro
            self::EmAndamento => 'bg-warning text-dark border border border-black', // Amarelo/Laranja (requer atenção)
            self::Pendente => 'bg-secondary text-white border border border-black', // Cinza/Laranja (depende da sua definição de secondary)
            self::Devolvido => 'bg-danger text-white border border border-black', // Vermelho (problema, cancelado ou requer ação imediata)
            self::Concluido => 'bg-success text-white border border border-black', // Verde (sucesso, finalizado)
        };
    }
}

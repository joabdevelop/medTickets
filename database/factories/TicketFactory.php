<?php

namespace Database\Factories;

use App\Models\Departamento;
use App\Models\Ticket;
use App\Models\Tipo_servico;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Profissional;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * O nome do Model correspondente.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * O contador para o número do ticket.
     *
     * @var int
     */
    protected static $ticketNumber = 1;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Define o status do ticket usando um array de opções.
        // Adicione seus ENUMS (Aberto, Em Andamento, etc.) aqui.
        $statuses = ['Aberto', 'Em Andamento', 'Pendente', 'Devolvido', 'Concluído'];

        // Busca um executante aleatório
        $executanteId = Profissional::inRandomOrder()->first();

        // 1. Encontra um Tipo_servico aleatório.
        $tipo_Servico = Tipo_servico::inRandomOrder()->first();

        $siglaDeptoExec = null; // Inicializa a variável como nula

        // Verifica se encontrou algum Tipo_servico
        if ($tipo_Servico) {
            // 2. Acessa a propriedade departamento_id do objeto $tipo_Servico.
            $deptoId = $tipo_Servico->executante_departamento_id;

            // 3. Usa o método find() do modelo Departamento para buscar o registro.
            $departamento = Departamento::find($deptoId);

            // 4. Acessa a sigla do objeto $departamento, se ele foi encontrado.
            // Como você garantiu que o departamento_id é válido, essa verificação
            // é tecnicamente redundante, mas é a melhor prática.
            if ($departamento) {
                $siglaDeptoExec = $departamento->sigla_depto;
            }
        }

        // Busca um profissional solicitante aleatório com seu departamento
        $solicitante = Profissional::with('departamento')->inRandomOrder()->first();

        // Simula datas para tickets concluídos, pendentes ou em andamento
        $dataSolicitacao = $this->faker->dateTimeBetween('-1 year', 'now');
        $statusFinal = $this->faker->randomElement($statuses);

        $dataConclusao = null;
        $dataDevolucao = null;

        // Lógica de datas baseada no status
        if ($statusFinal === 'Concluído') {
            $dataConclusao = $this->faker->dateTimeBetween($dataSolicitacao, 'now');
        } elseif ($statusFinal === 'Devolvido') {
            $dataDevolucao = $this->faker->dateTimeBetween($dataSolicitacao, 'now');
        }

        return [
            // CAMPOS OBRIGATÓRIOS (NOT NULL)
            'numero_ticket'         => $siglaDeptoExec . '-' . str_pad(self::$ticketNumber++, 4, '0', STR_PAD_LEFT), // Gera um número de ticket sequencial com zeros à esquerda
            'descricao_servico'     => $this->faker->sentence(10),

            // Foreign Keys (Assumindo que você tem Factories para estes Models)
            'tipo_servico_id'       =>  $tipo_Servico,
            'user_id_solicitante'   => $solicitante->id,
            'empresa_id'            => Empresa::factory(),

            'origem_sigla_depto'    => $solicitante->departamento->sigla_depto, // Ex: 'RH', 'FIN', 'DP'

            // Datas e Status
            'data_solicitacao'      => $dataSolicitacao,
            'status_final'          => $statusFinal,

            // CAMPOS ANULÁVEIS (NULLABLE)
            'user_id_executante'    => $statusFinal === 'Aberto' ? null : $executanteId->id, // Será NULL em 50% das vezes
            'observacoes'           => $this->faker->optional()->paragraph(2),

            // Datas Opcionais
            'data_conclusao'        => $dataConclusao,
            'data_devolucao'        => $dataDevolucao,
        ];
    }
}

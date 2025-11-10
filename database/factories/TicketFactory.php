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
use App\Models\Sla;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

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
        
        // Adicionando uma verificação de segurança caso não exista Tipo_servico.
        if (!$tipo_Servico) {
            // Retorna um tempo limite padrão e uma prioridade se não houver Tipo_servico.
            return [
                // Defina os campos necessários para um Ticket, usando valores padrão
                'tempo_limite_minutos' => 15,
                'prioridade' => 1,
                // ... outros campos
            ];
        }

        Log::info('Tipo serviço: ' . $tipo_Servico->sla_id);
        
        // Tenta encontrar o SLA. Pode retornar null.
        $tempo_sla = Sla::find($tipo_Servico->sla_id);

        // CORREÇÃO: Usa o operador null-safe (disponível no PHP 8+) ou verifica se é nulo.
        // Se $tempo_sla for null, ele não tentará acessar tempo_limite_minutos,
        // retornando null, que será tratado pelo operador de coalescência nula (??) com o valor 15.
        $tempo_limite_minutos = $tempo_sla?->tempo_limite_minutos ?? 15;

        // Se estiver usando uma versão do PHP anterior a 8.0, use a sintaxe abaixo:
        /*
        $tempo_limite_minutos = $tempo_sla 
            ? $tempo_sla->tempo_limite_minutos 
            : 15;
        */

        $prioridade = $tipo_Servico->prioridade ?? 1;


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

        // Inicializa as variáveis 
        $dataConclusao = null;
        $dataDevolucao = null;
        $cumpriu_sla = false;
        $cumpriu = false;
        $tempoReal = 0;

        // Lógica de datas baseada no status
        if ($statusFinal === 'Concluído') {
            $dataConclusao = $this->faker->dateTimeBetween($dataSolicitacao, 'now');
            $tempoReal = Carbon::instance($dataSolicitacao)->diffInMinutes(Carbon::instance($dataConclusao));
            $cumpriu = ($tempoReal <= $tempo_limite_minutos) ? 0 : 1;
            $cumpriu_sla = $cumpriu;

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
            'prioridade'            => $prioridade,
            'cumpriu_sla'           => $cumpriu_sla,
            'tempo_execucao'        => $tempoReal,


            // Datas Opcionais
            'data_conclusao'        => $dataConclusao,
            'data_devolucao'        => $dataDevolucao,
        ];
    }
}

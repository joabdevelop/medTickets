<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon; // Adicionado para gerenciar datas
use App\Models\Departamento;

class TipoServicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        // Pega o timestamp atual, que será usado para created_at e updated_at
        $now = Carbon::now(); 

        $servicos = [
            'Abertura de chamado de SOC',
            'Atualizaçao modelo 1',
            'Cadastro de login/usuario/acessos',
            'Cadastro/manuteçao de exames',
            'Conversão PGR',
            'CRIAÇÃO/Atualização de HIERARQUIA',
            'Demandas diversas e-social',
            'Envio de recibos',
            'FIF excel',
            'Gravação e Criação de conteúdo',
            'Inativação de empresa digital',
            'Inativação de colaborador de empresa',
            'Inativação de empresa',
            'Maestro',
            'Manuteção de dados cadastrais',
            'Perfil ploomes',
            'Reset de login/ atualização login',
            'Reunião com clientes',
            'Reunião interna',
            'Saneamento SOC',
            'Suporte usuária/clientes',
            'Treinamento/reciclagem SOC',
            'Validação de documentos tecnicos',
        ];

        // Definindo as opções disponíveis para os campos
        $opcoesPrioridade = ['urgente', 'alta', 'media', 'baixa'];
        $quemSolicita = [0,1,2]; // 0-AMBOS 1-FUNCIONARIO 2-CLIENTE
        $opcoesSla = [1, 2, 3, 4, 5, 6]; // Valores em horas
        $opcoesSercicoAtivo = [true, false];
        $TituloNome = [
            'Digite o nome do serviço',
            'Digite a unidade, Setor, Cargo e CBO',
            'Digite a qualquer informação relevante',
            'Digite a quantidade de colaboradores',
            'Digite o dia que sera realizado o exame',
        ];

        // Dados fixos que não mudam entre os registros
        $dadosFixos = [
            'dados_add' => 0,
            'quem_solicita' => 0,
            'created_at' => $now,
            'updated_at' => $now,

        ];

        $dadosInserir = [];
        foreach ($servicos as $nomeServico) {
            
            // Gerando os valores aleatórios para CADA serviço dentro do loop
            $dadosAleatorios = [
                'executante_departamento_id' => Departamento::where('id', '!=', 1)->get()->random()->id,
                'prioridade' => $faker->randomElement($opcoesPrioridade),
                'sla' => $faker->randomElement($opcoesSla),
                'servico_ativo' => $faker->randomElement($opcoesSercicoAtivo),
                'titulo_nome' => $faker->randomElement($TituloNome),
                'quem_solicita' => $faker->randomElement($quemSolicita),
            ];

            // Combina os dados fixos, os dados aleatórios e o nome do serviço
            $dadosInserir[] = array_merge(
                $dadosFixos, 
                $dadosAleatorios, 
                [
                    'nome_servico' => $nomeServico,
                ]
            );
        }

        // Insere todos os dados de uma vez (melhor performance)
        DB::table('tipo_servicos')->insert($dadosInserir);
    }
}
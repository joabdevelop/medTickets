<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Limpa a tabela antes de inserir novos dados (opcional, remova se não quiser apagar dados existentes)
        // DB::table('tipo_servicos')->truncate();

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
        foreach ($servicos as $servico) {
            DB::table('tipo_servicos')->insert([
                'departamento_id' => 1, // Exemplo: ID 1 para o departamento. Ajuste conforme seus dados.
                'descricao_servico' => $servico,
                'prioridade' => 's/p', // Exemplo: 's/p' (sem prioridade). Ajuste conforme suas regras.
                'sla' => 3, // Exemplo: 3 (superior a 10 minutos). Ajuste conforme suas regras.
            ]);
        }
    }
};

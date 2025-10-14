<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Profissional;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $departamento = \App\Models\Departamento::first() ?? \App\Models\Departamento::create([
            'nome' => 'Relacionamento',
            'sigla_depto' => 'RELAC',
        ]);

        $user = \App\Models\User::where('email', 'admin@gmail.com')->first();

        $profissional = Profissional::create([
            'user_id' => $user->id,
            'nome' => 'Joabe',
            'telefone' => '11999999999',
            'departamento_id' => $departamento->id,
            'tipo_usuario' => 2,
            'tipo_acesso' => 'ADMIN',
            'profissional_ativo' => true,
        ]);

        // Agora busque o profissional pelo nome (ou use $profissional direto)
        \App\Models\Grupo::create([
            'nome_grupo' => 'Leo madeiras',
            'relacionamento_id' => $profissional->id,
        ]);

         // Ordem de execução: tabelas que NÃO dependem de outras vêm primeiro.
        // Tabela de Departamentos é crucial, então a chamamos primeiro.
        // Adicione aqui seu Seeder de Departamentos se ele existir.
        
        // 1. Populando a tabela de SLAs (PRIMEIRO PASSO CRÍTICO)
        $this->call(SlaSeeder::class);
        
        // 2. Populando a tabela de Tipos de Serviço (depende de SLAs e Departamentos)
        // Se a coluna 'departamento_id' é sempre 1 no TipoServicosTableSeeder,
        // o seeder de Departamentos deve garantir que o ID 1 exista.
        $this->call(TipoServicosTableSeeder::class); 

        // 3. Outros Seeders (Usuários, Empresas, etc.)
       
        $this->call(EmpresaSeeder::class);
        
        // Certifique-se de que a ordem aqui respeite as chaves estrangeiras.
        // Ex: TicketsSeeder só deve rodar se tipo_servicos e users já estiverem populados.

    }
}

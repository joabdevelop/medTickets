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

        $this->call(\Database\Seeders\EmpresaSeeder::class);
        $this->call(TipoServicosTableSeeder::class);
    }
}

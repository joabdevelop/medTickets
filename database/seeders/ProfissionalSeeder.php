<?php

namespace Database\Seeders;

use App\Models\Profissional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfissionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profissional::create([
            'user_id' => 1,
            'nome' => 'Admin',
            'telefone' => '11999999999',
            'departamento_id' => 3,
            'tipo_usuario' => 2,
            'tipo_acesso' => 'Admin',
            'profissional_ativo' => true,
            'grupo_id' => 1
        ]);

        Profissional::create([
            'user_id' => 2,
            'nome' => 'Joabe',
            'telefone' => '11999999999',
            'departamento_id' => 2,
            'tipo_usuario' => 2,
            'tipo_acesso' => 'Gestor',
            'profissional_ativo' => true,
            'grupo_id' => 2
        ]);

        Profissional::create([
            'user_id' => 3,
            'nome' => 'Maria',
            'telefone' => '11999999999',
            'departamento_id' => 1,
            'tipo_usuario' => 2,
            'tipo_acesso' => 'Cliente',
            'profissional_ativo' => true,
            'grupo_id' => 3
        ]);

        Profissional::create([
            'user_id' => 4,
            'nome' => 'Mazarope',
            'telefone' => '11999999999',
            'departamento_id' => 2,
            'tipo_usuario' => 1,
            'tipo_acesso' => 'Estagiario',
            'profissional_ativo' => true,
            'grupo_id' => 1
        ]);

        Profissional::create([
            'user_id' => 5,
            'nome' => 'Fernanda',
            'telefone' => '11999999999',
            'departamento_id' => 4,
            'tipo_usuario' => 2,
            'tipo_acesso' => 'Funcionario',
            'profissional_ativo' => true,
            'grupo_id' => 2
        ]);
    }
}

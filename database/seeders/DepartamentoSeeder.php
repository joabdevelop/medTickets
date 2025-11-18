<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Departamento::create([
            'nome' => 'Cliente',
            'sigla_depto' => 'CLIE',
        ]);

        Departamento::create([
            'nome' => 'Processamento de Dados',
            'sigla_depto' => 'PDD',
        ]);

        Departamento::create([
            'nome' => 'Operações',
            'sigla_depto' => 'OPE',
        ]);

        Departamento::create([
            'nome' => 'Relacionamento',
            'sigla_depto' => 'REL',
        ]);



        Departamento::create([
            'nome' => 'Suporte Técnico',
            'sigla_depto' => 'STC',
        ]);
    }
}

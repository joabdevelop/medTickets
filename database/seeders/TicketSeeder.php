<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Profissional;
use App\Models\TipoServico;
use App\Models\Empresa;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Garante que haja usuários suficientes (solicitantes e executantes)
        // Se a tabela users estiver vazia, cria 50 usuários adicionais.
        if (Profissional::count() < 6) {
            Profissional::factory(5 - Profissional::count())->create();
        }

        // 2. Cria 200 tickets usando a Factory.
        // A TicketFactory já contém a lógica para referenciar os usuários,
        // tipos de serviço e empresas criados em outros seeders/factories.
        Ticket::factory(200)->create();
    }
}

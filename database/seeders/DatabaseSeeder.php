<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Desativa a checagem de chaves estrangeiras (CRUCIAL para TRUNCATE)
        Schema::disableForeignKeyConstraints();

        $this->call([
            // Seeders que criam dados de dependência
            UserSeeder::class,
            DepartamentoSeeder::class,
            ProfissionalSeeder::class,
            GrupoSeeder::class, // Grupo deve vir antes de Empresa
            EmpresaSeeder::class,
            SlaSeeder::class,
            TipoServicosTableSeeder::class,

            // Seeders de dados que DEPENDEM dos outros (como Tickets)
            TicketSeeder::class,
        ]);

        // 2. Reativa a checagem de chaves estrangeiras
        Schema::enableForeignKeyConstraints();
    }
}

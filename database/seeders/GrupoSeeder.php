<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Agora busque o profissional pelo nome (ou use $profissional direto)
        Grupo::create([
            'nome_grupo' => 'Leo madeiras',
            'relacionamento_id' => 1,
        ]);

        Grupo::create([
            'nome_grupo' => 'Cacau Show',
            'relacionamento_id' => 2,
        ]);

        Grupo::create([
            'nome_grupo' => 'Boticario',
            'relacionamento_id' => 3,
        ]);

        
    }
}

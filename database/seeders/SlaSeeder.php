<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sla;

class SlaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ao invés de usar factory(), que exige um arquivo Factory configurado,
        // usamos o método create() do Model diretamente, pois os dados são fixos.
        
        Sla::create([
            'nome_sla' => '30 Minutos',
        ]);
        Sla::create([
            'nome_sla' => '1 Hora',
        ]);
        Sla::create([
            'nome_sla' => '2 Horas',
        ]);
        Sla::create([
            'nome_sla' => '4 Horas',
        ]);
        Sla::create([
            'nome_sla' => '8 Horas',
        ]);
        Sla::create([
            'nome_sla' => '24 Horas',
        ]);
        
        // Observação: Certifique-se de que o Model App\Models\Sla
        // tenha a propriedade $fillable ou $guarded configurada
        // para permitir a atribuição em massa do campo 'nome_sla'.
    }
}

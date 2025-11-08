<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
 
class SlaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
 
        DB::table('slas')->insert([
            [
                'nome_sla' => '30 minutos',
                'tempo_limite_minutos' => 30,
                'ativo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nome_sla' => '1 hora',
                'tempo_limite_minutos' => 60,
                'ativo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nome_sla' => '2 horas',
                'tempo_limite_minutos' => 120,
                'ativo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nome_sla' => '4 horas',
                'tempo_limite_minutos' => 240,
                'ativo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nome_sla' => '8 horas',
                'tempo_limite_minutos' => 480,
                'ativo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
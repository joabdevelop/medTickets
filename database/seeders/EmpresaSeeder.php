<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Busca o profissional pelo nome (ou outro campo único)
    $profissional = \App\Models\Profissional::where('nome', 'Joabe')->first();

    // Garante que encontrou o profissional antes de criar o grupo
    if ($profissional) {
      $grupoEmpresarial = Grupo::firstOrCreate(
        ['nome_grupo' => 'Grupo Teste15'],
        ['relacionamento_id' => $profissional->id]
      );
      $grupoEmpresarial = Grupo::firstOrCreate(
        ['nome_grupo' => 'Grupo Teste14'],
        ['relacionamento_id' => $profissional->id]
      );
    } else {
      // Se não encontrar, pode lançar uma exceção ou logar um erro
      throw new \Exception('Profissional Joabe não encontrado!');
    }

    // Atribui o ID do grupo empresarial ao modelo Empresa
    Empresa::unguard();
    $empresa = Empresa::factory()->make();
    $empresa->id_grupo = $grupoEmpresarial->id;
    $empresa->save();
    Empresa::reguard();

    Empresa::truncate();
    Empresa::factory()->count(50)->create();
  }
}

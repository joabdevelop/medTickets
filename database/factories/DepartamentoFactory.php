<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departamento>
 */
class DepartamentoFactory extends Factory
{
    /**
     * O nome do Model correspondente.
     *
     * @var string
     */
    protected $model = Departamento::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista de termos para criar nomes de departamentos que pareçam reais
        $termos = ['Suporte', 'Financeiro', 'RH', 'Comercial', 'Desenvolvimento', 'Operações', 'Legal', 'Marketing'];
        $siglas = ['Sup', 'Fin', 'RH', 'Com', 'Dev', 'Ops', 'Leg', 'Mar'];
        
        return [
            // Cria um nome de departamento aleatório, mas coerente
            'nome' => $this->faker->unique()->randomElement($termos),
            'sigla_depto' =>  $this->faker->randomElement($siglas),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Profissional;
use App\Models\User;
use App\Models\Departamento;
use App\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfissionalFactory extends Factory
{
    /**
     * O nome do Model correspondente.
     *
     * @var string
     */
    protected $model = Profissional::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Garante que haja um User associado para evitar erros de FK
        $userId = User::factory();

        // Garante que haja um Departamento associado para evitar erros de FK
        $departamentoId = Departamento::factory();

        // Seus Seeders já criam alguns dados, mas a Factory precisa de uma base.
        // Já que você está usando um ProfissionalSeeder com dados fixos,
        // a Factory é usada para criar DADOS ADICIONAIS.

        return [
            // O campo 'user_id' precisa ser único, então criamos um novo User
            'user_id' => $userId,
            'nome' => $this->faker->name,
            'telefone' => $this->faker->numerify('###########'), // 11 dígitos
            'grupo_id' => Grupo::inRandomOrder()->first(),
            'departamento_id' => $departamentoId,
            'tipo_usuario' => $this->faker->randomElement([1, 2]), // Cliente (1) ou Colaborador/Pdd/Rel (2)
            'tipo_acesso' => $this->faker->randomElement(['Admin', 'Pdd', 'Cliente', 'Rel']),
            'profissional_ativo' => $this->faker->boolean(90), // 90% de chance de ser ativo
        ];
    }
}

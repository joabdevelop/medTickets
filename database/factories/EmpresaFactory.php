<?php

namespace Database\Factories;

use App\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    public function definition(): array
    {

        $this->faker->locale('pt_BR');
        $modalidades = ["PRIME", "POOL", "PD SITE", "NUCLEO", "NUCLEO ENG"];
        $renovacaoTipos = ["REN MAN", "REN AUT"];
        $fifStatus = ["CORTESIA", "OK", "PENDENTE"];
        $isCnpj = $this->faker->boolean;
        $codigofiscal = $isCnpj
            ? $this->faker->unique()->numerify('##.###.###/####-##')
            : $this->faker->unique()->numerify('###.###.###-##');
        // ...existing code...
        $gruposClassificacao = ["I", "II"];
        $profissionais = 1; // IDs dos profissionais
        // Define tipo_codigo_fiscal baseado no tamanho do código fiscal
        //$tipo_codigo_fiscal = strlen(preg_replace('/\D/', '', $codigofiscal)) === 14 ? 1 : 2;
        return [
            'nome_fantasia' => $this->faker->company,
            'razao_social' => $this->faker->company . ' LTDA',
            'codigo_fiscal' => $codigofiscal,
            'email_contato' => $this->faker->unique()->companyEmail,
            'grupo_classificacao' => $this->faker->randomElement($gruposClassificacao),
            'id_grupo' => Grupo::inRandomOrder()->first(),
            'bloqueio_status_financ' => $this->faker->boolean,
            'status_produto_preco' => $this->faker->boolean,
            'modalidade' => $this->faker->randomElement($modalidades),
            'ultima_renovacao' => $this->faker->date(),
            'ultima_renovacao_tipo' => $this->faker->randomElement($renovacaoTipos),
            'FIF_status' => $this->faker->randomElement($fifStatus),
            'FIF_data_liberacao' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'data_contrato' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'bloqueio_status_financ' => $this->faker->boolean,
            'status_produto_preco' => $this->faker->boolean,
        ];
    }
}

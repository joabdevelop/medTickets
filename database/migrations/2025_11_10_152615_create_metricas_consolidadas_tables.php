<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metricas_consolidadas', function (Blueprint $table) {
            $table->id();

            // CHAVES DE AGRUPAMENTO (DIMENSÕES)
            // Agrupamento principal por dia (para gráficos de tendência)
            $table->date('data_metrica')->index();

            // Chaves estrangeiras para permitir o agrupamento por:
            // 1. Agente (Desempenho da Equipe)
            $table->foreignId('user_id_executante')->nullable()->constrained('profissionals');

            // 2. Tipo de Serviço (SLA por Serviço)
            $table->foreignId('tipo_servico_id')->constrained('tipo_servicos');

            // 3. Departamento Solicitante (Análise de Cliente/Origem)
            $table->string('origem_sigla_depto', 10)->index();

            // MÉTRICAS AGREGADAS (FATOS)
            // Contagem de tickets para cálculo de produtividade e volume
            $table->unsignedInteger('total_tickets')->default(0)->comment('Total de tickets processados no agrupamento (dia, agente, serviço).');

            $table->unsignedInteger('tickets_concluidos')->default(0)->comment('Total de tickets com status "Concluído" no agrupamento.');

            // Para cálculo do percentual de SLA
            $table->unsignedInteger('tickets_sla_ok')->default(0)->comment('Contagem de tickets que cumpriram o SLA.');

            // Armazena a soma total do tempo para calcular a média
            $table->bigInteger('tempo_total_execucao_segundos')->default(0)->comment('Soma do tempo_execucao em segundos de todos os tickets no agrupamento.');

            // Útil para calcular o tempo médio de resolução (AVG)
            // Não é a média, mas sim o total de tickets para o cálculo posterior:
            // tempo_total_execucao_segundos / total_tickets_com_tempo
            $table->unsignedInteger('total_tickets_com_tempo')->default(0)->comment('Contagem de tickets que possuem tempo de execução > 0.');

            // Chave de unicidade (para evitar duplicatas no ETL)
            $table->unique(['data_metrica', 'user_id_executante', 'tipo_servico_id', 'origem_sigla_depto'], 'idx_metricas_unique_agrupamento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metricas_consolidadas');
    }
};

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

            $table->date('data_metrica')->index();
            $table->foreignId('user_id_executante')->nullable()->constrained('profissionals');
            $table->foreignId('tipo_servico_id')->constrained('tipo_servicos');
            $table->string('origem_sigla_depto', 10)->index();
            $table->string('status_final', 20)->index();

            $table->unsignedInteger('total_tickets')->default(0);
            $table->unsignedInteger('tickets_concluidos')->default(0);
            $table->unsignedInteger('tickets_devolvidos')->default(0);
            $table->unsignedInteger('tickets_sla_ok')->default(0);
            $table->bigInteger('tempo_total_execucao_segundos')->default(0);
            $table->unsignedInteger('total_tickets_com_tempo')->default(0);

            // ✅ Nome do índice customizado (curto)
            $table->unique(['data_metrica', 'user_id_executante', 'tipo_servico_id', 'origem_sigla_depto', 'status_final'], 'idx_metricas_unique_grp');

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

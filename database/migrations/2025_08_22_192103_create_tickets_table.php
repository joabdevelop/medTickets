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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('numero_ticket', 10)->index('idx_numero_ticket'); // Identificador do ticket
            $table->string('descricao_servico', 255); // Descricao do servico solicitado pelo usuario

            $table->unsignedBigInteger('tipo_servico_id'); // tipo_servico_id conectado com servico
            $table->foreign('tipo_servico_id')->references('id')->on('tipo_servicos');

            $table->string('origem_sigla_depto'); //código departamento do usuario solicitante o servico

            $table->unsignedBigInteger('user_id_solicitante'); // departamento_id conectado com solicitante
            $table->foreign('user_id_solicitante')->references('id')->on('profissionals');

            $table
                ->foreignId('user_id_executante')
                ->nullable()
                ->constrained('profissionals') // USANDO 'profissionals' conforme o seu erro
                ->onDelete('set null');

            $table->unsignedBigInteger('empresa_id'); // empresa_id conectado com empresa
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->text('observacoes')->nullable();
            $table->integer('prioridade')->default(1); // Prioridade vindo da tabela tipo Serviços
            $table->boolean('cumpriu_sla')->default(false);
            $table->unsignedBigInteger('tempo_execucao')->default(0); // Tempo que tomou para resolver o ticket

            // datas
            $table->datetime('data_solicitacao')->nullable(false);
            $table->datetime('data_conclusao')->nullable(true);
            $table->datetime('data_devolucao')->nullable(true);
            $table->string('status_final', 20)->default('Aberto'); //Enums app\Enums\StatusTickets.php  [aberto, em andamento, Pendente, devolvido (caso erros e pendencias), concluido]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

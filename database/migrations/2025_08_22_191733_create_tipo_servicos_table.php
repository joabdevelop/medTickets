<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipo_servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_servico', 50); // nome do servico para exibir na tela
            $table->string('titulo_nome', 50); // titulo para exibir na tela
            $table->unsignedBigInteger('executante_departamento_id');
            $table->foreign('executante_departamento_id')->references('id')->on('departamentos');
            $table->enum('prioridade', [
                'alta',
                'media',
                'baixa',
                'urgente'
            ])->default('media'); // Hardcoded, sem class
            $table->unsignedBigInteger('sla'); // 1: 30min, 2: 1h, 3: 1h30
            $table->foreign('sla')->references('id')->on('slas'); // Foreign key para tabela slas
            $table->integer('dados_add')->default(0); // 0: sem dados adicionais, 1: dados adicionais obrigatórios
            $table->integer('quem_solicita')->default(0); // 0: ambos, 1: equipe interna, 2: cliente
            $table->boolean('servico_ativo')->default(true); // verificar se o servico esta ativo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_servicos');
    }
};

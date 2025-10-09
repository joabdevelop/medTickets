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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_servico');
            $table->unsignedBigInteger('descricao_servico_id');
            $table->foreign('descricao_servico_id')->references('id')->on('tipo_servicos');

            $table->string('origem_sigla_depto');    //código departamento para evitar linkar com a tabela

            $table->unsignedBigInteger('user_id_solicitante');     // departamento_id conectado com solicitante
            $table->foreign('user_id_solicitante')->references('id')->on('users');
            $table->unsignedBigInteger('user_id_executante');
            $table->foreign('user_id_executante')->references('id')->on('users');

            $table->string('empresa',50);
            $table->string('unidade_empresa',50);
            // dados de HIERARQUIA // só mostra estes dados na tela qdo o serv for  criar/alterar hierarquia
            $table->string('setor',50);
            $table->string('cargo',255);
            $table->string('cbo',7);
            $table->string('descritivo_cargo',20);
             // datas
            $table->datetime('data_solicitacao');
            $table->datetime('data_conclusao');
            $table->datetime('data_devolucao');
            $table->string('status_final',20);   //[aberto, em andamento, Pendente, devolvido (caso erros e pendencias), concluido]

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

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
        Schema::create('profissionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nome', 50);
            $table->string('telefone', 15)->nullable();
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->integer('tipo_usuario')->nullable(); // 1-cliente ou 2-funcionario
            $table->string('tipo_acesso', 20)->default(""); // ADMIN, GESTOR, PDD, RELACIONAMENTO E OPERACIONAL
            $table->boolean('profissional_ativo')->default(true); //->after('tipo_acesso'); // Ativo ou Inativo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionals');
    }
};

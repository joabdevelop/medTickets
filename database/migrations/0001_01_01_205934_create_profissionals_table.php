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
            
            // Chaves externas que não causam circularidade
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            // $table->unsignedBigInteger('departamento_id');
            // $table->foreign('departamento_id')->references('id')->on('departamentos');

            $table->string('nome', 50);
            $table->string('telefone', 15)->nullable();

            $table->integer('tipo_usuario')->default(1); // 1: Cliente, 2: Funcionario
            
            // O campo 'grupo_id' pode ser criado, mas a foreign key será adicionada na Etapa 3
            $table->unsignedBigInteger('grupo_id'); 
            // REMOVIDO: $table->foreign('grupo_id')... (Será adicionado na Etapa 3)
            
            $table->string('tipo_acesso', 20)->default(""); // ADMIN, GESTOR, CLIENTE, FUNCIONARIO, ESTAGIARIO
            $table->boolean('profissional_ativo')->default(true); 
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

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
        // 1. Adiciona a chave 'relacionamento_id' à tabela 'grupos' (Grupos -> Profissionais)
        Schema::table('grupos', function (Blueprint $table) {
            $table->unsignedBigInteger('relacionamento_id')->nullable(false)->after('eh_cliente');
            $table->foreign('relacionamento_id')->references('id')->on('profissionals')->onDelete('cascade');
        });

        // 2. Adiciona a chave 'grupo_id' à tabela 'profissionals' (Profissionais -> Grupos)
        Schema::table('profissionals', function (Blueprint $table) {
            // A coluna 'grupo_id' já existe; apenas adicionamos a chave estrangeira
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a chave 'relacionamento_id' de 'grupos'
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign(['relacionamento_id']);
            $table->dropColumn('relacionamento_id');
        });

        // Remove a chave 'grupo_id' de 'profissionals'
        Schema::table('profissionals', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
        });
    }
};
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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_fantasia', 50);
            $table->string('razao_social', 144);
            $table->string('codigo_fiscal', 18)->unique();
            $table->string('email_contato', 100);
            $table->date('data_contrato')->nullable(false); // NOVO ou ANTIGO
            $table->string('grupo_classificacao', 2)->default("I"); // I ou II
            $table->unsignedBigInteger('id_grupo');
            $table->foreign('id_grupo')->references('id')->on('grupos');
            $table->boolean('bloqueio_status_financ')->default(false);
            $table->boolean('status_produto_preco')->default(false);
            $table->string('modalidade',10)->default("PRIME"); // PRIME, POOL, PD SITE, NUCLEO, NUCLEO ENG
            $table->date('ultima_renovacao')->nullable();
            $table->string('ultima_renovacao_tipo', 10)->default("REN MAN"); // REN MANUAL ou REN AUTO
            $table->string('FIF_status', 10)->default("PENDENTE"); // CORTESIA, OK, PENDENTE, RENOV AUT
            $table->date('FIF_data_liberacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

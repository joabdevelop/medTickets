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
       Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_grupo', 40)->unique();
            $table->enum('eh_cliente', ['CLIENTE', 'FUNCIONARIO',])->default('CLIENTE');
            
            // REMOVIDO: $table->unsignedBigInteger('relacionamento_id'); (Será adicionado na Etapa 3)
            // REMOVIDO: $table->foreign('relacionamento_id')... 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};

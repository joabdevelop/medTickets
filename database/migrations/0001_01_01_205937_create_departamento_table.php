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
        Schema::create('departamentos', function (Blueprint $table) {     
            $table->id();
            $table->string('nome', 40)->nullable(false);
            $table->string('sigla_depto', 10)->nullable(false)->index('idx_sigla_depto');
            //  PDD, OPERAC, RELAC, SAUD, AREA TEC
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_departamento');
    }
};

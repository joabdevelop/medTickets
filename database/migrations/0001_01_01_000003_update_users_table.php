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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('user_bloqueado')->default(false)->after('remember_token'); // Novo campo para bloquear usuário
            $table->renameColumn('last_activity', 'ultimo_acesso'); // Altera o tipo da coluna 'last_activity' para timestamp e permite nulo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

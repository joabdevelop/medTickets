<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes (Authenticated Area)
|--------------------------------------------------------------------------
| Centraliza rotas do painel autenticado. Facilita aplicar middlewares
| comuns e manter o routes/web.php mais enxuto.
|
| Quando quiser restringir apenas administradores, adicione o middleware
| 'role:admin' (ou similar) no grupo abaixo.
*/

Route::middleware(['auth', 'verified'])
    // ->middleware(['role:admin']) // habilite quando for necessário
    ->group(function () {
        // Resources (CRUD)
        Route::resource('empresa', \App\Http\Controllers\EmpresaController::class);
        Route::resource('grupo', \App\Http\Controllers\GrupoController::class);
        Route::resource('profissional', \App\Http\Controllers\ProfissionalController::class);
        Route::resource('departamento', \App\Http\Controllers\DepartamentoController::class);
        Route::resource('tipo_servico', \App\Http\Controllers\TipoServicoController::class);

        // Ações adicionais não-CRUD
        Route::patch('profissional/{profissional}/toggle', [\App\Http\Controllers\ProfissionalController::class, 'toggle'])
            ->name('profissional.toggle');

        Route::get('grupos/{grupo}/empresas', [\App\Http\Controllers\GrupoController::class, 'empresas'])
            ->name('grupos.empresas');
    });

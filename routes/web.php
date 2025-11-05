<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // To show the logged-in user's profile
    Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');

    // To show the logged-in user's profile
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');

    // To display the form to create a new user
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');

    // To store the new user data
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    // To display the form to edit the logged-in user's profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // To submit the updated profile data
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // To delete the user's account (use with caution!)
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource routes for EmpresaController
Route::resource('empresa', \App\Http\Controllers\EmpresaController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'empresa.index',
        'create' => 'empresa.create',
        'store' => 'empresa.store',
        'show' => 'empresa.show',
        'edit' => 'empresa.edit',
        'update' => 'empresa.update',
        'destroy' => 'empresa.destroy',
    ]);


// Resource routes for GrupoController
Route::resource('grupo', \App\Http\Controllers\GrupoController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'grupo.index',
        'create' => 'grupo.create',
        'store' => 'grupo.store',
        'show' => 'grupo.show',
        'edit' => 'grupo.edit',
        'update' => 'grupo.update',
        'destroy' => 'grupo.destroy',
    ]);

// Resource routes for ProfissionalController
Route::resource('profissional', \App\Http\Controllers\ProfissionalController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'profissional.index',
        'create' => 'profissional.create',
        'store' => 'profissional.store',
        'show' => 'profissional.show',
        'edit' => 'profissional.edit',
        'update' => 'profissional.update',
        'destroy' => 'profissional.destroy',
    ]);


Route::post('profissional/{profissional}/toggle', [\App\Http\Controllers\ProfissionalController::class, 'toggle'])
    ->middleware(['auth', 'verified'])
    ->name('profissional.toggle');

Route::resource('departamento', \App\Http\Controllers\DepartamentoController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'departamento.index',
        'create' => 'departamento.create',
        'store' => 'departamento.store',
        'show' => 'departamento.show',
        'edit' => 'departamento.edit',
        'update' => 'departamento.update',
        'destroy' => 'departamento.destroy',
    ]);

Route::get('/grupos/{grupo}/empresas', [\App\Http\Controllers\GrupoController::class, 'empresas']);

Route::resource('tipo_servico', \App\Http\Controllers\TipoServicoController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'tipo_servico.index',
        'create' => 'tipo_servico.create',
        'store' => 'tipo_servico.store',
        'show' => 'tipo_servico.show',
        'edit' => 'tipo_servico.edit',
        'update' => 'tipo_servico.update',
        'destroy' => 'tipo_servico.destroy',
    ]);

// Rota para alternar o status 'servico_ativo' de um TipoServico.
// O formulário Blade usa @method('PUT') para simular este método HTTP.
Route::put('tipo_servico/{tipo_servico}/toggle', [\App\Http\Controllers\TipoServicoController::class, 'toggleServicoAtivo'])
    ->middleware(['auth', 'verified'])
    ->name('tipo_servico.toggleServicoAtivo');

Route::resource('solicitaServico', \App\Http\Controllers\SolicitaServicoController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'solicitaServico.index',
        'create' => 'solicitaServico.create',
        'store' => 'solicitaServico.store',
        'show' => 'solicitaServico.show',
        'edit' => 'solicitaServico.edit',
        'update' => 'solicitaServico.update',
        'destroy' => 'solicitaServico.destroy',
    ]);

Route::resource('ticket', \App\Http\Controllers\TicketsController::class)
->middleware(['auth', 'verified'])
->names([
    'index' => 'ticket.index',
    'create' => 'ticket.create',
    'store' => 'ticket.store',
    'show' => 'ticket.show',
    'edit' => 'ticket.edit',
    'update' => 'ticket.update',
    'destroy' => 'ticket.destroy',
]);

Route::post('/ticket/atender/{ticket_id}',[
    \App\Http\Controllers\TicketsController::class, 
    'aceitarAtendimento'
])->middleware(['auth', 'verified'])->name('ticket.aceitarAtendimento');

Route::post('/ticket/devolver/{ticket_id}',[
    \App\Http\Controllers\TicketsController::class, 
    'devolverAtendimento'
])->middleware(['auth', 'verified'])->name('ticket.devolverAtendimento');

Route::post('/ticket/encerrar/{ticket_id}',[
    \App\Http\Controllers\TicketsController::class, 
    'encerrarAtendimento'
])->middleware(['auth', 'verified'])->name('ticket.encerrarAtendimento');


require __DIR__ . '/auth.php';

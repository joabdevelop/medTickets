## Como criar um crud?
- criar uma pasta na views com o nome da class, copiar index.blade.php, como modelo, de outra pasta.
- Verificar se o MODEL esta criado
- Verificar se o CONTROLLER esta criado

## OBS: -Comando para cria o MODEL e CONTROLLER 
php artisan make:model Unidades -mcr    

## Após a criação do MODEL, VIEWS e CONTROLLER se cria as rotas * VEJA O EXEMPLO:

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

## Colocar no menu da aplicação em CONFIG/ADMINPANEL

- Testar no navegado se esta tudo funcionando.
- Programar no CONTROLLER para enviar para VIEW os dados do modelo.
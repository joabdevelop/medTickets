<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
       protected $fillable = [
        'user_id',
        'nome',
        'telefone',
        'departamento_id',
        'tipo_usuario',
        'tipo_acesso',
    ];

    protected $table = 'profissionals';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }
}


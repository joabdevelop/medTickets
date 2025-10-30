<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use App\Enums\TipoUsuario;

class Profissional extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'telefone',
        'grupo_id',
        'departamento_id',
        'tipo_usuario',
        'tipo_acesso',
    ];

    protected $table = 'profissionals';

    protected $casts = [
        'tipo_usuario' => TipoUsuario::class, // Pega a legenda no enum 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id', 'id');
    }
}

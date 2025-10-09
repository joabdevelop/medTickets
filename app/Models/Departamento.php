<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'nome',
        'sigla',
    ];
    public function profissionais()
    {
        return $this->hasMany(\App\Models\Profissional::class, 'departamento_id');
    }
}

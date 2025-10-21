<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'sigla_depto',
    ];
    protected $table = 'departamentos';
    public function profissionais()
    {
        return $this->hasMany(\App\Models\Profissional::class, 'departamento_id');
    }
}

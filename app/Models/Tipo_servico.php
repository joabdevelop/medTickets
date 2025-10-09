<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tipo_servico extends Model
{
   use HasFactory;
    protected $fillable = [
        'departamento_id',
        'descricao_servico',
        'prioridade',
        'sla'
    ];
    protected $table = 'tipo_servicos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'mysql';
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date'
    ];
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

}

 
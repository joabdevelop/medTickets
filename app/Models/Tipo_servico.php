<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_servico extends Model
{
    protected $fillable = [
        'nome_servico',
        'executante_departamento_id',
        'prioridade',
        'sla',
        'dados_add',
        'quem_solicita',
        'servico_ativo',
        'titulo_nome',
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
        return $this->belongsTo(Departamento::class, 'executante_departamento_id', 'id');
    }
}

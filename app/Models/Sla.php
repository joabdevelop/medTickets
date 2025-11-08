<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    protected $fillable = [
        'nome_sla',
        'tempo_limite_minutos',
        'ativo'
    ];
    protected $table = 'slas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'mysql';
    
    public function tipo_servico()
    {
        return $this->hasMany(Tipo_servico::class, 'sla_id');
    }

}

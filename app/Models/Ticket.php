<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_ticket',
        'descricao_servico',
        'tipo_servico_id',
        'origem_sigla_depto',
        'user_id_solicitante',
        'user_id_executante',
        'empresa_id',
        'observacoes',
        'data_solicitacao',
        'data_conclusao',
        'data_devolucao',
        'status_final',
    ];

    protected $table = 'tickets';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'mysql';
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date'
    ];
    
    public function tipo_servico()
    {
        return $this->belongsTo(Tipo_Servico::class, 'tipo_servico_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function user_solicitante()
    {
        return $this->belongsTo(Profissional::class, 'user_id_solicitante');
    }

    public function user_executante()
    {
        return $this->belongsTo(Profissional::class, 'user_id_executante');
    }

}


     
           
  
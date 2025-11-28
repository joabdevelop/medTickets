<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetricasConsolidadas extends Model
{
    protected $fillable = [
        'data_metrica',
        'user_id_executante',
        'tipo_servico_id',
        'origem_sigla_depto',
        'status_final',
        'total_tickets',
        'tickets_concluidos',
        'tickets_devolvidos',
        'tickets_sla_ok',
        'tempo_total_execucao_segundos',
        'total_tickets_com_tempo',
        'created_at',   
        'updated_at',
    ];

    protected $table = 'metricas_consolidadas';

    protected $casts = [
        'data_metrica' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Profissional::class, 'user_id_executante', 'id');
    }

    public function tipoServico()
    {
        return $this->belongsTo(TipoServico::class, 'tipo_servico_id', 'id');
    }

    public function origem()
    {
        return $this->belongsTo(Departamento::class, 'origem_sigla_depto', 'sigla_depto');
    }

     public function executante()
    {
        return $this->belongsTo(Profissional::class, 'user_id_executante');
    }


}

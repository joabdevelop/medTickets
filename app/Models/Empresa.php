<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_grupo',
        'nome_fantasia',
        'razao_social',
        'codigo_fiscal',
        'email_contato',
        'grupo_classificacao',
        'modalidade',
        'ultima_renovacao',  // Nome consistente
        'ultima_renovacao_tipo',
        'FIF_status',
        'FIF_data_liberacao',
        'data_contrato',
        'bloqueio_status_financ',
        'status_produto_preco'
    ];

    protected $casts = [
        'data_contrato' => 'date',
        'ultima_renovacao' => 'date',  // Alinhado com $fillable
        'FIF_data_liberacao' => 'date',
        'bloqueio_status_financ' => 'boolean',  // Opcional: cast para checkbox
        'status_produto_preco' => 'boolean',    // Opcional: cast para checkbox
    ];

    // Relação com Grupo, se aplicável
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id');
    }

    public function getCodigoFiscalFormatadoAttribute()
    {
        $doc = $this->codigo_fiscal;

        if (strlen($doc) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $doc);
        } elseif (strlen($doc) === 14) {
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $doc);
        }

        return $doc;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome_grupo',
        'grupo_id',
        'relacionamento_id'
    ];
    protected $table = 'grupos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'mysql';
    protected $casts = ['created_at' => 'date'];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'relacionamento_id', 'id');
    }
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'id_grupo', 'id');
    }
    public function relacionamento()
    {
        return $this->belongsTo(User::class, 'relacionamento_id', 'id');
    }
}



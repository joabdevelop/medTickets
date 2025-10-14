<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    protected $fillable = [
        'nome_sla'
    ];
    protected $table = 'slas';
    protected $primaryKey = 'id';
}

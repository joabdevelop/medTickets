<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ultimo_acesso', // Assuming this is a datetime field for tracking last activity
        'user_bloqueado', // Campo para indicar se o usuário está bloqueado
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ultimo_acesso' => 'datetime',
        'user_bloqueado' => 'boolean',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function gruposRelacionados()
    {
        return $this->hasMany(Grupo::class, 'relacionamento_id');
    }

    public function empresas()
    {
        // Se quiser acessar empresas via grupos relacionados
        return $this->hasManyThrough(Empresa::class, Grupo::class, 'relacionamento_id', 'grupo_id');
    }
}

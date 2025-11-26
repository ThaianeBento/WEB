<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutirao extends Model
{
    protected $fillable = [
        'nome', 'data', 'local', 'capacidade', 'status', 'observacoes'
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function veterinarios()
    {
        return $this->belongsToMany(Veterinario::class, 'mutirao_veterinario')
                    ->withPivot('funcao')
                    ->withTimestamps();
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}

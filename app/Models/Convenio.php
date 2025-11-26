<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $fillable = [
        'nome', 'tipo', 'contato', 'valor_castracao', 'status',
        'data_inicio', 'data_fim', 'ativo', 'termos'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativo' => 'boolean',
    ];

    public function precos()
    {
        return $this->hasMany(Preco::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}

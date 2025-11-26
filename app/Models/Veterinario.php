<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $fillable = [
        'nome', 'cpf', 'crmv', 'telefone', 'email', 
        'endereco', 'bairro', 'cidade', 'uf', 'cep'
    ];

    public function mutiraos()
    {
        return $this->belongsToMany(Mutirao::class, 'mutirao_veterinario')
                    ->withPivot('funcao')
                    ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = ['nome', 'tipo', 'telefone', 'email', 'cpf', 'endereco', 'bairro', 'cep', 'cidade', 'uf', 'observacoes'];

    public function animais()
    {
        return $this->hasMany(Animal::class);
    }
}

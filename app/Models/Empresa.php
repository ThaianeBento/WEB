<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'razao_social', 'cnpj', 'telefone', 'email', 
        'endereco', 'bairro', 'cidade', 'uf', 'cep'
    ];
}

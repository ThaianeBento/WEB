<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doacao extends Model
{
    protected $fillable = [
        'data_doacao', 'animal_id', 'adotante_nome', 'adotante_contato', 'observacoes'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}

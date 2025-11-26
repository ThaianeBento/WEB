<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    protected $fillable = [
        'convenio_id', 'descricao', 'valor', 'especie', 'peso_min', 'peso_max'
    ];

    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }
}

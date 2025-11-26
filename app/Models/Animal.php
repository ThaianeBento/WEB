<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'nome', 'especie', 'raca', 'idade', 'peso', 'sexo', 'cor', 
        'castrado', 'disponivel_doacao', 'observacoes', 'foto_url', 
        'tutor_id', 'status', 'microchip', 'porte', 'srd', 
        'data_nascimento_estimada', 'status_reprodutivo'
    ];

    public function images()
    {
        return $this->hasMany(AnimalImage::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function doacao()
    {
        return $this->hasOne(Doacao::class);
    }
}

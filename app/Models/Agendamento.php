<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'data_agendamento', 'horario', 'valor', 'status', 'observacoes', 
        'animal_id', 'tutor_id', 'convenio_id', 'mutirao_id',
        'peso_medido', 'jejum_ok'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }

    public function mutirao()
    {
        return $this->belongsTo(Mutirao::class);
    }
    //
}

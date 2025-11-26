<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalImage extends Model
{
    protected $fillable = ['animal_id', 'path', 'is_primary'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}

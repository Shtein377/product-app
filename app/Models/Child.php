<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable([
    'name',
    'birth_date',
    'gender',
    'birth_weight_g',
    'birth_height_cm',
    'gestation_weeks',
    'blood_type',
    'rh_factor',
    'allergies',
    'notes',
    'avatar_path',
])]
class Child extends Model
{
    use SoftDeletes;

     protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'birth_weight_g' => 'integer',
            'birth_height_cm' => 'decimal:1',
            'gestation_weeks' => 'integer',
        ];
    }
}

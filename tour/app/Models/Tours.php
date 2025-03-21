<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    protected $table = "tours";

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'duration',
        'price',
        'category_id',
        'subcategory_id',
        'quota',
        'transportation_id',
        'hotel_id',
        'director_id',
        'supervisor_id',
    ];
}

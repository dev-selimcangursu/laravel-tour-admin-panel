<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourFeatures extends Model
{
    protected $table = 'tour_features';
    protected $fillable = ['tour_id', 'featured_id', 'status_id'];

  

}

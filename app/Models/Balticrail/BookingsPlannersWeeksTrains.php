<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsPlannersWeeksTrains extends Model
{
    protected $connection = 'balticrail';

    use HasFactory;

    public function train()
    {
        return $this->belongsTo('App\Models\Balticrail\Trains','train_id','id');
    }

}

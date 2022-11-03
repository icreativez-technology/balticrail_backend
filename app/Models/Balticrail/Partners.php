<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    protected $connection = 'balticrail';

    use HasFactory;

    public function partner_representative()
    {
        return $this->hasOne('App\Models\Balticrail\PartnersRepresentatives','partner_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Balticrail\Countries');
    }


}

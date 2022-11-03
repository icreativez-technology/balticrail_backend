<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    protected $connection = 'railway';

    use HasFactory;

    public function partner_representative()
    {
        return $this->hasOne('App\Models\Railway\PartnersRepresentatives','partner_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Railway\Countries');
    }


}

<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    public function partner_representative()
    {
        return $this->hasOne('App\Models\Transport\PartnersRepresentatives','partner_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Transport\Countries');
    }


}

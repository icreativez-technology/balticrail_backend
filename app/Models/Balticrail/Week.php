<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $connection = 'balticrail';
    protected $fillable = ['name','from_date','to_date'];
    
    protected $casts = [
        'from_date'  => 'date:d.m.y',
        'to_date'    => 'date:d.m.y'
    ];
    public function trains(){
        return $this->hasMany(Vehicles::class,'week_id','id');
    }

}

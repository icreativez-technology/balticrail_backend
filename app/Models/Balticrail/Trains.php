<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trains extends Model
{
    protected $connection = 'balticrail';
    protected $table = 'vehicles';

    use HasFactory;

    public function train_week(){
        return $this->belongsTo(Week::class,'week_id','id');
    }
}

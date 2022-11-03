<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainWeek extends Model
{
    use HasFactory;
    protected $connection = 'balticrail';

    protected $fillable = [
        'train_id',
        'week_id'
    ];
}

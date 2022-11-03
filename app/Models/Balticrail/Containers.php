<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Containers extends Model
{
    use HasFactory;
    protected $connection = 'balticrail';

}

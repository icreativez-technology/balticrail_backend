<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueCodes extends Model
{
    protected $connection = 'balticrail';

    use HasFactory;
}

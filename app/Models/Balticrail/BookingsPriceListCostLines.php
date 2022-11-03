<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsPriceListCostLines extends Model
{
    use HasFactory;
    protected $connection = 'balticrail';

}

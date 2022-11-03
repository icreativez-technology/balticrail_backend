<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsFiles extends Model
{
    use HasFactory;
    protected $connection = 'balticrail';

}

<?php

namespace App\Models\Balticrail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCodes extends Model
{
    protected $connection = 'balticrail';

    use HasFactory;
}

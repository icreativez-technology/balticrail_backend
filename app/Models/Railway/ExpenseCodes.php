<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCodes extends Model
{
    protected $connection = 'railway';

    use HasFactory;
}

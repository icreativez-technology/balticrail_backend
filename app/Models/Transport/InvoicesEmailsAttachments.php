<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesEmailsAttachments extends Model
{
    protected $connection = 'transport';
    use HasFactory;
}

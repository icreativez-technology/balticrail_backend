<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersFiles extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    public function document_type()
    {
        return $this->belongsTo('App\Models\Transport\DocumentsTypes','document_type_id','id');
    }
}

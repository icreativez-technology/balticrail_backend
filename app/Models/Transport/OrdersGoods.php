<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersGoods extends Model
{
    protected $connection = 'transport';
    use HasFactory;

    public function pieces_unit()
    {
        return $this->belongsTo('App\Models\Transport\PiecesUnits','piece_type_id','id');
    }

    public function unit_type()
    {
        return $this->belongsTo('App\Models\Transport\Units','unit_type_id','id');
    }

}

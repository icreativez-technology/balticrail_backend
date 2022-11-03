<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $connection = 'transport';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'order_id',
        'master_order_id',
        'order_type_id',
        'customer_partner_id',
        'pickup_partner_id',
        'pickup_date',
        'pickup_time',
        'pickup_country_id',
        'pickup_city',
        'pickup_postal_code',
        'pickup_longitude',
        'pickup_latitude',
        'pickup_address',
        'delivery_partner_id',
        'delivery_date',
        'delivery_time',
        'delivery_country_id',
        'delivery_city',
        'delivery_postal_code',
        'delivery_longitude',
        'delivery_latitude',
        'delivery_address',
        'custom_partner_id',
        'custom_country_id',
        'custom_city',
        'custom_postal_code',
        'custom_longitude',
        'custom_latitude',
        'custom_address',
        'reference',
        'remarks',
        'terms',
        'source_document',
        'user_type',
        'carrier_partner_id',
        'truck_id',
        'trailer_id',
        'pieces',
        'real_weight',
        'units',
        'calc_weight',
        'description',
        'marks',
        'code',
        'package_type',
        'measure',
        'status',
        'created_by',
        'sync_id'
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\Transport\User','user_id','id');
    }

    public function order_master()
    {
        return $this->belongsTo('App\Models\Transport\OrdersMasters','master_order_id','id');
    }

    public function order_type()
    {
        return $this->belongsTo('App\Models\Transport\OrdersTypes','order_type_id','id');
    }

    public function carrier_partner()
    {
        return $this->belongsTo('App\Models\Transport\Partners','carrier_partner_id','id');
    }

    public function customer_partner()
    {
        return $this->belongsTo('App\Models\Transport\Partners','customer_partner_id','id');
    }

    public function pickup_partner()
    {
        return $this->belongsTo('App\Models\Transport\Partners','pickup_partner_id','id');
    }

    public function delivery_partner()
    {
        return $this->belongsTo('App\Models\Transport\Partners','delivery_partner_id','id');
    }

    public function truck()
    {
        return $this->hasOne('App\Models\Transport\Vehicles','id','truck_id')->where('vehicle_type_id','=',1);
    }

    public function trailer()
    {
        return $this->hasOne('App\Models\Transport\Vehicles','id','trailer_id')->where('vehicle_type_id','=',2);
    }

    public function pickup_country()
    {
        return $this->hasOne('App\Models\Transport\Countries','id','pickup_country_id');
    }

    public function delivery_country()
    {
        return $this->hasOne('App\Models\Transport\Countries','id','delivery_country_id');
    }

    public function custom_country()
    {
        return $this->hasOne('App\Models\Transport\Countries','id','custom_country_id');
    }

    public function cmr()
    {
        return $this->hasOne('App\Models\Transport\OrdersCmr','order_id','id');
    }
    
    public function cmr_yellow_printed()
    {
        return $this->hasOne('App\Models\Transport\OrdersCmrYellowPrinted','order_id','id');
    }

    public function goods()
    {
        return $this->hasMany('App\Models\Transport\OrdersGoods','order_id','id')->with('pieces_unit')->with('unit_type');
    }


}

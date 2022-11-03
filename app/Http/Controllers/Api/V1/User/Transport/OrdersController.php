<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

#Model
use App\Models\Transport\Orders;
use App\Models\Transport\OrdersCmr;
use App\Models\Transport\OrdersCmrDetails;
use App\Models\Transport\OrdersFiles;
use App\Models\Transport\OrdersGoods;
use App\Models\Transport\OrdersMasters;
use App\Models\Transport\OrdersProfitsExpenses;
use App\Models\Transport\OrdersProfitsRevenues;

#Request 
use App\Http\Requests\User\Transport\Orders\StoreRequest;
use App\Http\Requests\User\Transport\Orders\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class OrdersController extends Controller
{
    public $user_id;
    public $pagination;

    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public function __construct()
    {
        $this->user_id = Auth::id();
        $this->pagination = $this->pagination_count();
    }

    public function index()
    {
        $data = Orders::with('user','truck','trailer','order_master',
                             'order_type','carrier_partner','customer_partner','pickup_country',
                             'pickup_partner','delivery_partner',
                             'delivery_country','custom_country')->paginate($this->pagination);
        $response = $data;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function save_master_order($data)
    {
        $master_id = 0;
     
        if(isset($data['master_order_id']) && $data['master_order_id'] == "New")
        {
            $master = new OrdersMasters();
            $master->order_type_id = isset($data['order_type_id']) ? $data['order_type_id'] : 0;
            $master->pickup_date =  isset($data['pickup_date']) ? $data['pickup_date'] : null;
            $master->delivery_date =  isset($data['delivery_date']) ? $data['delivery_date'] : null;
            $master->carrier_partner_id = isset($data['carrier_partner_id']) ? $data['carrier_partner_id'] : 0;
            $master->truck_id = isset($data['truck_id']) ? $data['truck_id'] : 0;
            $master->trailer_id = isset($data['trailer_id']) ? $data['trailer_id'] : 0;
            $master->save();

            $master->order_id = "M".$master->id;
            $master->save();

            $master_id = $master->id;
        }

        if(isset($data['master_order_id']) && $data['master_order_id'] != "New")
        {
            $master_id = $data['master_order_id'];
        }


        return $master_id;
    }

    public function save_order($data,$master_id,$order_id = 0)
    {


        $this->user_id = Auth::id();

        if($order_id > 0)
        {
            $order = Orders::where('id','=',$order_id)->first();
        }
        else
        {
            $order = new Orders;
            $order->order_id = isset($data['order_id']) ? $data['order_id'] : 0;
        }

        $order->order_type_id = isset($data['order_type_id']) ? $data['order_type_id'] : 0;
        $order->customer_partner_id = isset($data['customer_partner_id']) ? $data['customer_partner_id'] : 0;
        $order->pickup_partner_id = isset($data['pickup_partner_id']) ? $data['pickup_partner_id'] : 0;
        $order->pickup_date = isset($data['pickup_date']) ? $data['pickup_date'] : null;
        $order->pickup_time = isset($data['pickup_time']) ? $data['pickup_time'] : null;
        $order->pickup_city = isset($data['pickup_city']) ? $data['pickup_city'] : null;
        $order->pickup_postal_code = isset($data['pickup_postal_code']) ? $data['pickup_postal_code'] : null;
        $order->pickup_longitude = isset($data['pickup_longitude']) ? $data['pickup_longitude'] : null;
        $order->pickup_latitude = isset($data['pickup_latitude']) ? $data['pickup_latitude'] : null;
        $order->pickup_address = isset($data['pickup_address']) ? $data['pickup_address'] : null;
        $order->pickup_country_id = isset($data['pickup_country_id']) ? $data['pickup_country_id'] : null;
        $order->delivery_partner_id = isset($data['delivery_partner_id']) ? $data['delivery_partner_id'] : 0;
        $order->delivery_date = isset($data['delivery_date']) ? $data['delivery_date'] : null;
        $order->delivery_time = isset($data['delivery_time']) ? $data['delivery_time'] : null;
        $order->delivery_city = isset($data['delivery_city']) ? $data['delivery_city'] : null;
        $order->delivery_postal_code = isset($data['delivery_postal_code']) ? $data['delivery_postal_code'] : null;
        $order->delivery_longitude = isset($data['delivery_longitude']) ? $data['delivery_longitude'] : null;
        $order->delivery_latitude = isset($data['delivery_latitude']) ? $data['delivery_latitude'] : null;
        $order->delivery_address = isset($data['delivery_address']) ? $data['delivery_address'] : null;
        $order->delivery_country_id = isset($data['delivery_country_id']) ? $data['delivery_country_id'] : null;
        $order->custom_partner_id = isset($data['custom_partner_id']) ? $data['custom_partner_id'] : 0;
        $order->custom_city = isset($data['custom_city']) ? $data['custom_city'] : null;
        $order->custom_postal_code = isset($data['custom_postal_code']) ? $data['custom_postal_code'] : null;
        $order->custom_longitude = isset($data['custom_longitude']) ? $data['custom_longitude'] : null;
        $order->custom_latitude = isset($data['custom_latitude']) ? $data['custom_latitude'] : null;
        $order->custom_address = isset($data['custom_address']) ? $data['custom_address'] : null;
        $order->custom_country_id = isset($data['custom_country_id']) ? $data['custom_country_id'] : null;
        $order->reference = isset($data['reference']) ? $data['reference'] : null;
        $order->remarks = isset($data['remarks']) ? $data['remarks'] : null;
        $order->terms = isset($data['terms']) ? $data['terms'] : null;
        $order->source_document = isset($data['source_document']) ? $data['source_document'] : null;
        $order->user_type = isset($data['user_type']) ? $data['user_type'] : null;
        $order->master_order_id = $master_id;
        $order->carrier_partner_id = isset($data['carrier_partner_id']) ? $data['carrier_partner_id'] : 0;
        $order->truck_id = isset($data['truck_id']) ? $data['truck_id'] : 0;
        $order->trailer_id = isset($data['trailer_id']) ? $data['trailer_id'] : 0;
        $order->created_by = $this->user_id;
        $order->user_id = $this->user_id;
        $order->sync_id = isset($data['sync_id']) ? $data['sync_id'] : 0; 
        $order->save();

        if($order_id == 0)
        {
            $order->order_id = "ID".$order->id;
            $order->save();           
        }

        return $order;
    }

    public function add_goods($data,$order)
    {
        OrdersGoods::where('order_id','=',$order->id)->delete();

        $total_pieces = 0;
        $kg_calc = 0;
        $description = "";
        $marks = "";
        $units = 0;

        if(isset($data['goods']))
        {
            foreach($data['goods'] as $value)
            {
                $orders_goods = new OrdersGoods;
                $orders_goods->order_id = $order->id;
                $orders_goods->pieces = isset($value['pieces']) ? $value['pieces'] : 0;
                $orders_goods->piece_type_id = isset($value['piece_type_id']) ? $value['piece_type_id'] : 0;
                $orders_goods->unit = isset($value['unit']) ? $value['unit'] : 0;
                $orders_goods->unit_type_id = isset($value['unit_type_id']) ? $value['unit_type_id'] : 0;
                $orders_goods->kg_calc = isset($value['kg_calc']) ? $value['kg_calc'] : 0;
                $orders_goods->cost = isset($value['cost']) ? $value['cost'] : 0;
                $orders_goods->ldm = isset($value['ldm']) ? $value['ldm'] : 0;
                $orders_goods->volume = isset($value['volume']) ? $value['volume'] : 0;
                $orders_goods->length = isset($value['length']) ? $value['length'] : 0;
                $orders_goods->weight = isset($value['weight']) ? $value['weight'] : 0;
                $orders_goods->height = isset($value['height']) ? $value['height'] : 0;
                $orders_goods->description = isset($value['description']) ? $value['description'] : "";
                $orders_goods->marks = isset($value['marks']) ? $value['marks'] : "";
                $orders_goods->save();

                $total_pieces = $total_pieces + $orders_goods->pieces;
                $kg_calc = $kg_calc + $orders_goods->kg_calc;
                $units = $units + $orders_goods->unit;

                if(!empty($orders_goods->description))
                {
                    $description = $orders_goods->description;
                }

                if(!empty($orders_goods->marks))
                {
                    $marks = $orders_goods->marks;
                }
            }
        }        
    
        $record = array();
        $record['total_pieces'] = $total_pieces;
        $record['kg_calc'] = $kg_calc;
        $record['units'] = $units;
        $record['description'] = $description;
        $record['marks'] = $marks;
        $record['order'] = $order;

        return $record;   
    }


    public function add_expenses($data,$order)
    {
        OrdersProfitsExpenses::where('order_id','=',$order->id)->delete();

        if(isset($data['profit_expense']))
        {
            foreach($data['profit_expense'] as $value)
            {
                $profit_expense = new OrdersProfitsExpenses();
                $profit_expense->order_id = $order->id;
                $profit_expense->expense_code_id = isset($value['expense_code_id']) ? $value['expense_code_id'] : 0;
                $profit_expense->price = isset($value['price']) ? $value['price'] : 0;
                $profit_expense->quantity = isset($value['quantity']) ? $value['quantity'] : 0;
                $profit_expense->sum = isset($value['sum']) ? $value['sum'] : 0;
                $profit_expense->currency_id = isset($value['currency_id']) ? $value['currency_id'] : 0;
                $profit_expense->description = isset($value['description']) ? $value['description'] : 0;
                $profit_expense->date = (isset($value['date']) && !empty($value['date'])) ? $value['date'] : null;
                $profit_expense->carrier_partner_id = isset($value['carrier_partner_id']) ? $value['carrier_partner_id'] : 0;
                $profit_expense->vehicle_id = isset($value['vehicle_id']) ? $value['vehicle_id'] : 0;
                $profit_expense->save();
            }
        }
    }

    public function add_revenues($data,$order)
    {
        OrdersProfitsRevenues::where('order_id','=',$order->id)->delete();

        if(isset($data['profit_revenue']))
        {
            foreach($data['profit_revenue'] as $value)
            {
                $profit_revenue = new OrdersProfitsRevenues();
                $profit_revenue->order_id = $order->id;
                $profit_revenue->revenue_code_id = isset($value['revenue_code_id']) ? $value['revenue_code_id'] : 0;
                $profit_revenue->price = isset($value['price']) ? $value['price'] : 0;
                $profit_revenue->quantity = isset($value['quantity']) ? $value['quantity'] : 0;
                $profit_revenue->sum = isset($value['sum']) ? $value['sum'] : 0;
                $profit_revenue->currency_id = isset($value['currency_id']) ? $value['currency_id'] : 0;
                $profit_revenue->description = isset($value['description']) ? $value['description'] : 0;
                $profit_revenue->date = (isset($value['date']) && !empty($value['date'])) ? $value['date'] : null;
                $profit_revenue->carrier_partner_id = isset($value['carrier_partner_id']) ? $value['carrier_partner_id'] : 0;
                $profit_revenue->vehicle_id = isset($value['vehicle_id']) ? $value['vehicle_id'] : 0;
                $profit_revenue->save();
            }
        }
    }


    public function store(StoreRequest $request)
    {

        try
        {
            $data = $request->all();
            // $user_id = $this->user_id;
            // //$data['user_id'] = $user_id;
            $master_id = $this->save_master_order($data);
            $order = $this->save_order($data,$master_id);

            $order_cmr = new OrdersCmr();
            $order_cmr->order_id = $order->id;
            $order_cmr->save();

            $types = array('carriage_charges','deduction','balance','supplier_charges','other','total');

            foreach($types as $value)
            {
                $order_cmr_detail = new OrdersCmrDetails();
                $order_cmr_detail->order_id = $order->id;
                $order_cmr_detail->order_cmr_id = $order_cmr->id;
                $order_cmr_detail->type = $value;
                $order_cmr_detail->save();
            }

            $record = $this->add_goods($data,$order);

            $order->pieces = $record['total_pieces'];
            $order->calc_weight = $record['kg_calc'];
            $order->description = $record['description'];
            $order->marks = $record['marks'];
            $order->units = $record['units'];
            $order->save();

            $this->add_expenses($data,$order);
            $this->add_revenues($data,$order);

            $response = [
                'message' => __('api.record_added'),
                'data' => $order
            ];

            $status = Response::HTTP_OK;

            return response($response, $status);
        }
        catch(\Throwable $e) {
            $response = [
                'message' => $e->getMessage()
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }
    }


    public function show($id)
    {
        try
        {
            $user_id = $this->user_id;
            $order = Orders::find($id);

            $goods = OrdersGoods::where('order_id','=',$order->id)->get();
            $profit_revenue = OrdersProfitsRevenues::where('order_id','=',$order->id)->get();
            $profit_expense = OrdersProfitsExpenses::where('order_id','=',$order->id)->get();

            if(isset($order->id))
            {
                $status = Response::HTTP_OK;

                $response = [
                    'order' => $order,
                    'goods' => $goods,
                    'profit_revenue' => $profit_revenue,
                    'profit_expense' => $profit_expense,
                ];
            }
            else
            {
                $response = [
                    'message' => __('api.invalid_id'),
                ];

                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            }

            return response($response, $status);
        }
        catch(\Throwable $e) {
            $response = [
                'message' => $e->getMessage()
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }
    }


    public function update(UpdateRequest $request, $id)
    {
       
        $data = $request->all();
        try
        {
            $order  = Orders::where('id',$id)->first();
            if(isset($order))
            {   
                $master_id = $this->save_master_order($data);

                if(isset($data['goods'])){
                    $this->add_goods($data,$order);
                }
                if(isset($data['profit_expense'])){
                    $this->add_expenses($data,$order);
                }
                if(isset($data['profit_revenue'])){
                    $this->add_revenues($data,$order);
                }

                unset($data['goods']);
                unset($data['profit_expense']);
                unset($data['profit_revenue']);
                
                $updateOrder  = Orders::where('id',$id)->update($data);

                $response = [
                    'message' =>  __('api.record_updated'),
                    'data' => $updateOrder
                ];    
            }
            else
            {
                $response = [
                    'message' => __('api.invalid_id'),
                ];

                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            }

            $status = Response::HTTP_OK;

            return response($response, $status);
        }
        catch(\Throwable $e) {

            $response = [
                'tech' => $this->tech_error($e),
                'message' => __('api.server_issue')
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            return response($response, $status);
        }        
    }


    public function destroy($id)
    {
        $user_id = $this->user_id;
        $order = Orders::where('id','=',$id)->first();

        OrdersProfitsExpenses::where('order_id','=',$id)->delete();
        OrdersProfitsRevenues::where('order_id','=',$id)->delete();
        OrdersGoods::where('order_id','=',$id)->delete();
        OrdersFiles::where('order_id','=',$id)->delete();
        OrdersCmr::where('order_id','=',$id)->delete();
        OrdersCmrDetails::where('order_id','=',$id)->delete();

        if(isset($order->id))
        {
            $order->delete();

            $response = [
                'message' => __('api.record_deleted'),
            ];

            $status = Response::HTTP_OK;
        }
        else
        {
            $response = [
                'message' => __('api.invalid_id'),
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response($response, $status);
    }

    public function new_order_id()
    {
        $latest_record = Orders::OrderBy('id','DESC')->first();

        $new_id = $latest_record->id + 1;

        $response = [
            'id' => "ID".$new_id
        ];

        $status = Response::HTTP_OK;
        return response($response, $status);
    }

}
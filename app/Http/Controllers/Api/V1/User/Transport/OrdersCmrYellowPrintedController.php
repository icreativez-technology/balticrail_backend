<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

#Models
use App\Models\Transport\Orders;
use App\Models\Transport\OrdersCmrYellowPrinted;

#Request 
use App\Http\Requests\User\Transport\OrdersCmrYellowPrinted\StoreRequest;
use App\Http\Requests\User\Transport\OrdersCmrYellowPrinted\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

use PDF;


class OrdersCmrYellowPrintedController extends Controller
{
    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public $user_id;
    public $pagination;

    public function __construct()
    {
        $this->user_id = Auth::id();
        $this->pagination = $this->pagination_count();
    }

    public function show($id)
    {
        $order = Orders::with('user','truck','trailer','order_master',
        'order_type','carrier_partner','customer_partner','pickup_country',
        'pickup_partner','delivery_partner',
        'delivery_country','custom_country','cmr','cmr_yellow_printed','goods')->find($id);


        $response = [
            'order' => $order
        ];

        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function generate_pdf($id)
    {
     
        $order = Orders::with('user','truck','trailer','order_master',
        'order_type','carrier_partner','customer_partner','pickup_country',
        'pickup_partner','delivery_partner',
        'delivery_country','custom_country','cmr','cmr_yellow_printed')->find($id);

        $cmr = OrdersCmrYellowPrinted::where('order_id','=',$id)->first();

        $data = [
            'order' => $order,
            'cmr' => $cmr
        ];

        $pdf = PDF::loadView('user.transport.template_1', $data);

        $path = 'pdf';
        $fileName =  date('Ymdhis').".pdf";
        $complete_file = $path . '/' . $fileName;
        $pdf->save($complete_file);

        $response = [
            'pdf' => asset($complete_file)
        ];

        $status = Response::HTTP_OK;
        return response($response, $status);

        //return $pdf->download('test.pdf');
    }

    public function update(UpdateRequest $request)
    {
        $order_cmr = OrdersCmrYellowPrinted::with('cmr_detail')->where('order_id','=',$request->id)->first();

        if(!isset($order_cmr->id))
        {
            $order_cmr = new OrdersCmrYellowPrinted;
            $order_cmr->order_id = $request->id;
        }

        $order_cmr->cnt_number = $request->cnt_number;
        $order_cmr->size_type = $request->size_type;
        $order_cmr->seal = $request->seal;
        $order_cmr->gross_weight = $request->gross_weight;
        $order_cmr->cargo_description = $request->cargo_description;
        $order_cmr->customer = $request->customer;
        $order_cmr->customer_address = $request->customer_address;
        $order_cmr->customer_place = $request->customer_place;
        $order_cmr->door_date = $request->door_date;
        $order_cmr->door_hour = $request->door_hour;
        $order_cmr->drop_off_place = $request->drop_off_place;
        $order_cmr->cnt_owner = $request->cnt_owner;
        $order_cmr->driver_gate_out = $request->driver_gate_out;
        $order_cmr->cc = $request->cc;
        $order_cmr->last_free_day = $request->last_free_day;
        $order_cmr->save();

        $response = $order_cmr;
        $status = Response::HTTP_OK;

        return response($response, $status);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\User\Transport;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

#Model
use App\Models\Transport\Orders;
use App\Models\Transport\OrdersCmr;
use App\Models\Transport\OrdersCmrDetails;

#Request 
use App\Http\Requests\User\Transport\OrdersCmr\StoreRequest;
use App\Http\Requests\User\Transport\OrdersCmr\UpdateRequest;

#Trait
use App\Http\Traits\CommonFunctionsTrait;
use App\Http\Traits\ImageFunctionsTrait;

class OrdersCmrController extends Controller
{
    use CommonFunctionsTrait;
    use ImageFunctionsTrait;

    public $user_id;
    public $pagination;

    public function __construct()
    {
        $this->user_id = Auth::guard('transport')->id();
        $this->pagination = $this->pagination_count();
    }

    public function display_calendar()
    {
        $form_html =  view('user.transport.calendar')->render();
        return $form_html;
    }

    public function select_template($id, Request $request)
    {
        $order = Orders::with('user','truck','trailer','order_master',
        'order_type','carrier_partner','customer_partner','pickup_country',
        'pickup_partner','delivery_partner',
        'delivery_country','custom_country','cmr')->find($id);

        $carriage_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','carriage_charges')->first();
        $deduction = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','deduction')->first();
        $balance = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','balance')->first();
        $supplier_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','supplier_charges')->first();
        $other = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','other')->first();
        $total = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','total')->first();

        $cmr = OrdersCmr::where('order_id','=',$id)->first();

        $data = [
            'carriage_charges' => $carriage_charges,
            'deduction' => $deduction,
            'balance' => $balance,
            'supplier_charges' => $supplier_charges,
            'other' => $other,
            'total' => $total,
            'order' => $order,
            'cmr' => $cmr
        ];

        if($request->template == 3)
        {
            $customPaper = array( 0, 0, 790.866, 683.15);
            $pdf = PDF::loadView('user.transport.template_'.$request->template, $data)->setPaper($customPaper, 'landscape');
        }
        else
        {
            $pdf = PDF::loadView('user.transport.template_'.$request->template, $data);
        }
        
        if(isset($request->html) && $request->html == 1)
        {
            $form_html =  view('user.transport.template_'.$request->template)->with($data)->render();
            return $form_html;
        }
        
        return $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
    }


    public function display_form($id,Request $request)
    {
        $token = $request->bearerToken();

        //$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiYTQ5NTdiZWM4MDRhYzQyYjVhOGQzZjVhNDg4YjYwNTM0NGQ4NTIxMzU0Y2Y4YTJkMDE0ODEzYjU0YThhNzYzY2NmYTFmZmI5NjVhZmNiYTMiLCJpYXQiOjE2NDU1MTI0MTMuNTY4MjE2LCJuYmYiOjE2NDU1MTI0MTMuNTY4MjIsImV4cCI6MTY3NzA0ODQxMy41NjYzMjcsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.hcdg7uKbPA30a6ixcy_UuR0fhi9EGTCjgrBBiCIFB58wYxv1gtsDUtN-GH_5Gr879YVNheCnJPPEq5crfWWkv33l-Y6w2ewEYgTBDt7ZPGoYcY_dfbJzTZWW0ovfh9Z_XJb3dDyT83hWVnQZ4908vCJbpbbJFRGH7t7jJRoartmc2krpoC_Oahd-QrkRz40RURTdKWYNPikfaH-REpG8fXEJWQMAcd0Y3JUwVExrc1kPqvO13KOPjBH4eRxIQgh_u8p6BLO7X0OtMo-4s0y-bEpypwwTTI4NjBqH0y7qvlvn4_i1ChpnvrWs53dOd6Wjj5XpxqaRz8lPEzd8hMdMXSLsDPPnAKvJl9M5qBZ8gNCO_IIpJhCfoQarYsJSiDJwtb5M-6xG8NgH1y-Mtn5LmDlEztJoQit5UeCQAnGon98w8FKpIqxxnO64lpQgHSxMyMwSogzWlaOu-3bSLIyoQs41KATxDHByJiBeoFCQwi6x0m9RUEHiq9BX_bk4u1FFnG8gJLvs7StdpAdJfHMj7nLiEbCp63fb4kEvB8qWsB86gWZWROwMmZAv97cSD72k41Uc0LO-i6oRdaCHFUbDuJ0hvfEG_BHz05GolIAFhh_QEc-tt8kCKMp3PliGESPPzcta26EI1B1G-g6S-4GxrKgPqohSJuav0_QGWkC7huA";

        $order = Orders::with('user','truck','trailer','order_master',
        'order_type','carrier_partner','customer_partner','pickup_country',
        'pickup_partner','delivery_partner',
        'delivery_country','custom_country','cmr','goods')->find($id);

        $carriage_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','carriage_charges')->first();
        $deduction = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','deduction')->first();
        $balance = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','balance')->first();
        $supplier_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','supplier_charges')->first();
        $other = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','other')->first();
        $total = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','total')->first();

        $response = [
            'order' => $order,
            'carriage_charges' => $carriage_charges,
            'deduction' => $deduction,
            'balance' => $balance,
            'supplier_charges' => $supplier_charges,
            'other' => $other,
            'total' => $total
        ];

        $response = array();

        $form_html =  view('user.transport.orders_cmr')->with(['order' => $order, 'token' => $token])->render();

        $response['form_html'] = $form_html;

        $status = Response::HTTP_OK;
        return $form_html;
    }

    public function show($id)
    {
        $order = Orders::with('user','truck','trailer','order_master',
        'order_type','carrier_partner','customer_partner','pickup_country',
        'pickup_partner','delivery_partner',
        'delivery_country','custom_country','cmr','goods')->find($id);

        $carriage_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','carriage_charges')->first();
        $deduction = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','deduction')->first();
        $balance = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','balance')->first();
        $supplier_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','supplier_charges')->first();
        $other = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','other')->first();
        $total = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','total')->first();

        $response = [
            'order' => $order,
            'carriage_charges' => $carriage_charges,
            'deduction' => $deduction,
            'balance' => $balance,
            'supplier_charges' => $supplier_charges,
            'other' => $other,
            'total' => $total
        ];

        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function generate_pdf($id)
    {
        $order = Orders::with('user','truck','trailer','order_master',
        'order_type','carrier_partner','customer_partner','pickup_country',
        'pickup_partner','delivery_partner',
        'delivery_country','custom_country','cmr','goods')->find($id);

        $carriage_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','carriage_charges')->first();
        $deduction = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','deduction')->first();
        $balance = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','balance')->first();
        $supplier_charges = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','supplier_charges')->first();
        $other = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','other')->first();
        $total = OrdersCmrDetails::where('order_id','=',$id)->where('type','=','total')->first();

        $sender = OrdersCmrDetails::with('user')->where('order_id',$id)->first();

        $cmr = OrdersCmr::where('order_id','=',$id)->first();

        $data = [
            'sender'=> $sender,
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

        $order_cmr = OrdersCmr::with('cmr_detail')->where('order_id','=',$request->id)->first();

        if(!isset($order_cmr->id))
        {
            $order_cmr = new OrdersCmr;
            $order_cmr->order_id = $request->id;
        }

        $order_cmr->sender = $request->sender;
        $order_cmr->consignee = $request->consignee;
        $order_cmr->place_of_delivery_goods = $request->place_of_delivery_goods;
        $order_cmr->place_of_taking_goods = $request->place_of_taking_goods;
        $order_cmr->sender_instruction = $request->sender_instruction;
        $order_cmr->return = $request->return;
        $order_cmr->payment_of_carriage_instruction = $request->payment_of_carriage_instruction;
        $order_cmr->other_agreements = $request->other_agreements;
        $order_cmr->save();

        $types = array('carriage_charges','deduction','balance','supplier_charges','other','total');

        $cmr_detail = $request->all();

        foreach($types as $value)
        {
            if(!isset($cmr_detail[$value]))
            {
                continue;
            }

            $order_cmr_detail = OrdersCmrDetails::where('order_cmr_id','=',$order_cmr->id)->where('type','=',$value)->first();
            if(!isset($order_cmr_detail->id))
            {
                $order_cmr_detail = new OrdersCmrDetails;
            }
            $order_cmr_detail->order_id = $request->id;
            $order_cmr_detail->order_cmr_id = $order_cmr->id;
            $order_cmr_detail->type = $value;
            $order_cmr_detail->sender = $cmr_detail[$value]['sender'];
            $order_cmr_detail->currency = $cmr_detail[$value]['currency'];
            $order_cmr_detail->consignee = $cmr_detail[$value]['consignee'];
            $order_cmr_detail->save();
        }

        $response = $order_cmr;
        $status = Response::HTTP_OK;

        return response($response, $status);
    }
}

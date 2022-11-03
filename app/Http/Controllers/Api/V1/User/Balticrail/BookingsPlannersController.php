<?php

namespace App\Http\Controllers\Api\V1\User\Balticrail;

use App\Http\Controllers\Controller;
use App\Models\Balticrail\Vehicles;
use App\Models\Balticrail\v2\Bookings;
use App\Models\Balticrail\TrainBooking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Balticrail\Trains;
use App\Models\Balticrail\BookingsPlanners;
use App\Models\Balticrail\BookingsPlannersWeeksTrains;

class BookingsPlannersController extends Controller
{
    public function weekly_trains() 
    {
        $records = BookingsPlannersWeeksTrains::with('train')->get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function get_unplanned_bookings() 
    {
        $records = Bookings::where('is_planned','=',0)->get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);
    }

    public function get_planned_bookings() 
    {
        $records = BookingsPlanners::with('booking')->get();
        $response = $records;
        $status = Response::HTTP_OK;
        return response($response, $status);        
    }

    public function save_week_train_booking(Request $request) {

        BookingsPlanners::where('booking_id','=',$request->booking_id)->delete();

        if(!isset($request->weeks_trains_id)) {

            $booking_planner = BookingsPlannersWeeksTrains::where('week_number','=',$request->week_number)->where('train_id','=',$request->train_number)->first();
            
            if(!isset($booking_planner->id)) {
                $response = ["message" => "Week Train not found"];
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                return response($response, $status);  
            } else {
                $weeks_trains_id = $booking_planner->id;
            }
        } else {
            $weeks_trains_id = $request->weeks_trains_id;
        }

        
        $planner = new BookingsPlanners;
        $planner->booking_id = $request->booking_id;
        $planner->week_number = $request->week_number;
        $planner->train_number = $request->train_number;
        $planner->weeks_trains_id = $weeks_trains_id;
        $planner->save();

        $booking = Bookings::find($request->booking_id);
        $booking->is_planned = $planner->id;
        $booking->save();

        $response = ["message" => "Booking Added Successfully"];
        $status = Response::HTTP_OK;
        return response($response, $status);  

    }

    public function delete_booking_planner($id)
    {
        $records = BookingsPlanners::where('id','=',$id)->first();

        $booking = Bookings::find($records->booking_id);
        $booking->is_planned = 0;
        $booking->save();

        $records->delete();

        $response = ["message" => "Planner Deleted Successfully"];
        $status = Response::HTTP_OK;
        return response($response, $status);        
    }


    public function addBookingToTrain(Request $request)
    {
        //dd($request->all());
        $data = $request->all();
        $trainBooking = TrainBooking::where("train_id",$request->train_id)
        ->where("booking_id",$request->booking_id)->first();
        if($trainBooking){
            $response = ["message" => "Sorry! This booking is already addeed in this train"];
            $status = 422;
            return response($response, $status); 
        }
        $response = TrainBooking::updateOrCreate($data);
        if($response){ 
            $records = Vehicles::with('train_week','train_booking')->get();
            $response = ["data"=>$records,"message" => "Booking Successfully Add To Train"];
            $status = Response::HTTP_OK;
            return response($response, $status); 
        }
    }

    public function addMultipleBookingToPlanner(Request $request)
    {
        
        //return $request->all();
        $bookingIds = $request->bookingIds;
        //return $bookingIds;
        $plannedBooking   = TrainBooking::where("train_id",$request->train_id)
        ->whereIn("booking_id",$bookingIds)->get();
        if(count($plannedBooking)){
            $response = ["message" => "Sorry! The Select booking is already addeed in this train"];
            $status = 422;
            return response($response, $status); 
        }
        if($request->action == 'copy'){
          
            if(isset($request->status)  && count($bookingIds) >= 1 && $request->status == 'copy-to-trian'){
                $trainBooking = TrainBooking::whereIn('booking_id',$request->bookingIds)
                ->where('train_id',$request->old_train_id)->get();
                     if($trainBooking){
                         foreach($trainBooking as $booking){
                            if($booking['is_copied'] == 1){
                                $response = ["message" => "Sorry! You can't make copy of copies"];
                                $status = 422;
                                return response($response, $status);
                            }
                            $response = TrainBooking::create([
                                'train_id'   =>$request->train_id,
                                'booking_id' =>$booking['booking_id'],
                                'is_copied'  =>1,
                                'old_id'     =>$request->old_train_id,
                                'new_id'     =>$request->train_id
                            ]);
                         }
                         
                         if($trainBooking){ 
                             $response = ["message" => "Booking Successfully Moved To Train"];
                             $status = Response::HTTP_OK;
                             return response($response, $status); 
                         }
                     }
            }

            $unPlannedBookingIds = TrainBooking::whereIn("booking_id",$bookingIds)->distinct()->pluck('booking_id');
            if(count($unPlannedBookingIds)){
                foreach($unPlannedBookingIds as $ids){
                    $response = TrainBooking::create([
                        'train_id'   =>$request->train_id,
                        'booking_id' =>$ids,
                        'is_copied'  =>1,
                        'old_id'     =>0,
                        'new_id'     =>$request->train_id
                    ]);
                }
                if($response){ 
                    $response = ["message" => "Booking Successfully Add To Train"];
                    $status = Response::HTTP_OK;
                    return response($response, $status); 
                }
            }else{
                $response = ["message" => "Sorry! You can't copy unplanned booking items"];
                $status = 422;
                return response($response, $status); 
            }
               
        }elseif($request->action == 'move'){
            
            if(isset($request->status)  && count($bookingIds) > 1 && $request->status == 'move-to-trian'){
               // return "OK";
                $trainBooking = TrainBooking::whereIn('booking_id',$request->bookingIds)
                ->where('train_id',$request->old_train_id)->get();
                //return $trainBooking;
                    if($trainBooking){
                        foreach($trainBooking as $booking){
                            $updateTrainBooking = TrainBooking::whereIn('booking_id',$request->bookingIds)
                            ->where('train_id',$request->old_train_id)
                            ->update(['train_id'=>$request->train_id,'old_id'=>$request->old_train_id,'new_id'=>$request->train_id]);
                        }
                        if(true){ 
                            $response = ["message" => "Booking Successfully Moved To Train"];
                            $status = Response::HTTP_OK;
                            return response($response, $status); 
                        }
                    }
              }

              if(isset($request->status) && $request->status == 'move-to-trian'){
                $trainBooking = TrainBooking::whereIn('booking_id',$request->bookingIds)->
                orWhere('is_copied',$request->is_copied)->first();
                    if($trainBooking){
                        $updateTrainBooking = TrainBooking::where('booking_id',$request->bookingIds)
                        ->where('train_id',$request->old_train_id)
                        ->update(['train_id'=>$request->train_id,'old_id'=>$request->old_train_id,'new_id'=>$request->train_id]);
                        if($updateTrainBooking){ 
                            $response = ["message" => "Booking Successfully Moved To Train"];
                            $status = Response::HTTP_OK;
                            return response($response, $status); 
                        }
                    }
              } 
              
            
              $plannedBooking = TrainBooking::whereIn("booking_id",$bookingIds)
              ->where('is_copied',0)->distinct()->pluck('booking_id');
                if(!count($plannedBooking)){
                    foreach($bookingIds as $ids){
                        $response = TrainBooking::create([
                            'train_id'   =>$request->train_id,
                            'booking_id' =>$ids,
                            'new_id'     =>$request->train_id,
                            'old_id'     =>0
                        ]);
                    }
                    if($response){ 
                        $response = ["message" => "Booking Successfully Add To Train"];
                        $status = Response::HTTP_OK;
                        return response($response, $status); 
                    }
                }else{
                    $response = ["message" => "Sorry! You can't move already moved booking items"];
                    $status = 422;
                    return response($response, $status); 
                }
               
            
        }
    }

    public function removeBooking(Request $request)
    {
        $response   = TrainBooking::where("booking_id",$request->booking_id)
        ->where('is_copied',$request->is_copied)
        ->where('train_id',$request->train_id)
        ->delete();
        if($response){ 
            $response = ["message" => "Booking Successfully Removed From Train"];
            $status = Response::HTTP_OK;
            return response($response, $status); 
        }
    }

}

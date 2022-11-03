<?php

use App\Models\Balticrail\Bookings;
use App\Models\Balticrail\BookingsGoods;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

Route::get('test',function(){

      $bookings =  Bookings::all();
      $array = array('outbound','inbound','passing');
      $value = Arr::random($array);
        foreach($bookings as $booking){
            Bookings::where('id',$booking['id'])->update([
                'booking_type'     =>array_rand($array,1)
            ]);
        }
            
      
});

Route::prefix('auth')->group(function () {
    
    Route::post('/register', 'App\Http\Controllers\Api\V1\Auth\Balticrail\RegisterController@register');
    Route::post('/login', 'App\Http\Controllers\Api\V1\Auth\Balticrail\LoginController@login');
    Route::post('/logout', 'App\Http\Controllers\Api\V1\Auth\Balticrail\LoginController@logout');
    Route::post('/forgot_password', 'App\Http\Controllers\Api\V1\Auth\Balticrail\ForgotPasswordController@index');
    Route::post('/reset_password', 'App\Http\Controllers\Api\V1\Auth\Balticrail\ResetPasswordController@index');
});


Route::middleware(['auth:api'])->group(function () {


       #UserRoutes
       Route::prefix('user')->group(function () {
        #LookUp CMS
        Route::apiResource('/bookings_types','App\Http\Controllers\Api\V1\User\Balticrail\BookingsTypesController');
        Route::apiResource('/containers','App\Http\Controllers\Api\V1\User\Balticrail\ContainersController');
        Route::apiResource('/countries','App\Http\Controllers\Api\V1\User\Balticrail\CountriesController');
        Route::apiResource('/currencies','App\Http\Controllers\Api\V1\User\Balticrail\CurrenciesController');
        Route::apiResource('/drivers','App\Http\Controllers\Api\V1\User\Balticrail\DriversController');
        Route::apiResource('/expense_codes','App\Http\Controllers\Api\V1\User\Balticrail\ExpenseCodesController');        
        Route::apiResource('/languages','App\Http\Controllers\Api\V1\User\Balticrail\LanguagesController');  
        Route::apiResource('/partners_types','App\Http\Controllers\Api\V1\User\Balticrail\PartnersTypesController');
        Route::apiResource('/revenue_codes','App\Http\Controllers\Api\V1\User\Balticrail\RevenueCodesController');        
        Route::apiResource('/terminals','App\Http\Controllers\Api\V1\User\Balticrail\TerminalsController');        
        Route::apiResource('/trains','App\Http\Controllers\Api\V1\User\Balticrail\TrainsController');        
        Route::apiResource('/users','App\Http\Controllers\Api\V1\User\Balticrail\UsersController');
        Route::apiResource('/vehicles','App\Http\Controllers\Api\V1\User\Balticrail\VehiclesController');
        Route::apiResource('/vehicles_types','App\Http\Controllers\Api\V1\User\Balticrail\VehiclesTypesController');

        #Partners
        Route::get('/partners/contacts/{id}','App\Http\Controllers\Api\V1\User\Balticrail\PartnersContactsController@index');
        Route::apiResource('/partners_contacts','App\Http\Controllers\Api\V1\User\Balticrail\PartnersContactsController');
        Route::apiResource('/partners','App\Http\Controllers\Api\V1\User\Balticrail\PartnersController');
        Route::get('/partners/representatives/{id}','App\Http\Controllers\Api\V1\User\Balticrail\PartnersRepresentativesController@index');
        Route::apiResource('/partners_representatives','App\Http\Controllers\Api\V1\User\Balticrail\PartnersRepresentativesController');

        #Me
        // Route::get('/me','App\Http\Controllers\Api\V1\User\Balticrail\ProfileController@show');

        ######### Bookings
        Route::apiResource('/bookings/sales_offers','App\Http\Controllers\Api\V1\User\Balticrail\BookingsSalesOffersController');
        Route::apiResource('/bookings/service/expense','App\Http\Controllers\Api\V1\User\Balticrail\BookingsServicesExpensesController');
        Route::apiResource('/bookings/service/service','App\Http\Controllers\Api\V1\User\Balticrail\BookingsServicesServicesController');
        Route::apiResource('/bookings/goods','App\Http\Controllers\Api\V1\User\Balticrail\BookingsGoodsController');
        Route::apiResource('/bookings/files','App\Http\Controllers\Api\V1\User\Balticrail\BookingsFilesController');
        Route::apiResource('/bookings/conditions','App\Http\Controllers\Api\V1\User\Balticrail\BookingsConditionsController');
        Route::apiResource('/bookings/weekly_trains','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersWeeksTrainsController');

        #Bookings CMR / GATE IN / GATE OUT

        Route::get('/bookings/planners/weekly_trains','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@weekly_trains');
        Route::get('/bookings/planners/get_unplanned_bookings','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@get_unplanned_bookings');
        Route::get('/bookings/planners/get_planned_bookings','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@get_planned_bookings');
        Route::post('/bookings/planners/save_week_train_booking','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@save_week_train_booking');
        Route::delete('/bookings/planners/delete_booking_planner','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@save_week_train_booking');
        Route::post('/bookings/planners/add_booking_to_train','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@addBookingToTrain');
        Route::post('/bookings/planners/add_multiple_booking_to_train','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@addMultipleBookingToPlanner');
        Route::post('/bookings/planners/remove_booking','App\Http\Controllers\Api\V1\User\Balticrail\BookingsPlannersController@removeBooking');

        

        Route::get('/bookings/cmr/{id}','App\Http\Controllers\Api\V1\User\Balticrail\BookingsCmrController@select_template');
        Route::get('/bookings/gate_in/{id}','App\Http\Controllers\Api\V1\User\Balticrail\BookingsGateInController@index');
        Route::get('/bookings/gate_out/{id}','App\Http\Controllers\Api\V1\User\Balticrail\BookingsGateOutController@index');

        Route::apiResource('/bookings','App\Http\Controllers\Api\V1\User\Balticrail\BookingsController');
        ######### Bookings END

        ######### V2 Bookings
        Route::apiResource('/v2/bookings','App\Http\Controllers\Api\V2\User\Balticrail\BookingsController');
        Route::post('/get_filtered_bookings','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@getFilteredBookings');   
   }); 

    #LookupTables  #FrontRoutes
    Route::prefix('front')->group(function () {
       
        Route::get('/bookings_types','App\Http\Controllers\Api\V1\User\Balticrail\BookingsTypesController@lookup');
        Route::get('/containers','App\Http\Controllers\Api\V1\User\Balticrail\ContainersController@lookup');
        Route::get('/countries','App\Http\Controllers\Api\V1\User\Balticrail\CountriesController@lookup');
        Route::get('/currencies','App\Http\Controllers\Api\V1\User\Balticrail\CurrenciesController@lookup');
        Route::get('/drivers','App\Http\Controllers\Api\V1\User\Balticrail\DriversController@lookup');
        Route::get('/expense_codes','App\Http\Controllers\Api\V1\User\Balticrail\ExpenseCodesController@lookup');
        Route::get('/languages','App\Http\Controllers\Api\V1\User\Balticrail\LanguagesController@lookup');
        Route::get('/partners_types','App\Http\Controllers\Api\V1\User\Balticrail\PartnersTypesController@lookup');
        Route::get('/revenue_codes','App\Http\Controllers\Api\V1\User\Balticrail\RevenueCodesController@lookup');     
        Route::get('/terminals','App\Http\Controllers\Api\V1\User\Balticrail\TerminalsController@lookup');
        Route::get('/trains','App\Http\Controllers\Api\V1\User\Balticrail\TrainsController@lookup');
        Route::get('/users','App\Http\Controllers\Api\V1\User\Balticrail\UsersController@lookup');  
        Route::get('/vehicles','App\Http\Controllers\Api\V1\User\Balticrail\VehiclesController@lookup');     
        Route::get('/vehicles_types','App\Http\Controllers\Api\V1\User\Balticrail\VehiclesTypesController@lookup');   
        Route::get('/partners/{type}','App\Http\Controllers\Api\V1\User\Balticrail\PartnersController@lookup');
       
       
        Route::get('/weeks','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@getWeeks');  
        Route::post('/create-week','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@createWeek');  
        Route::post('/update-week','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@updateWeek');  
        Route::get('/get_booking_data','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@getBookingData');   
        Route::get('/get_vehicles/{id}','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@getVehicles');   
        Route::post('/get_filtered_bookings','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@getFilteredBookings');   
        Route::post('/get_filtered_train_booking','App\Http\Controllers\Api\V1\User\Balticrail\GeneralController@getFilteredTrainBooking');   

    });

 

});
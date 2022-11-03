<?php
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', 'App\Http\Controllers\Api\V1\Auth\Transport\RegisterController@register');
    Route::post('/login', 'App\Http\Controllers\Api\V1\Auth\Transport\LoginController@login');
    Route::post('/logout', 'App\Http\Controllers\Api\V1\Auth\Transport\LoginController@logout');
    Route::post('/forgot_password', 'App\Http\Controllers\Api\V1\Auth\Transport\ForgotPasswordController@index');
    Route::post('/reset_password', 'App\Http\Controllers\Api\V1\Auth\Transport\ResetPasswordController@index');

});

Route::middleware(['auth:api'])->group(function () {

    #LookupTables  #FrontRoutes
    Route::prefix('front')->group(function () {
        
        Route::get('/countries','App\Http\Controllers\Api\V1\User\Transport\CountriesController@lookup');
        Route::get('/currencies','App\Http\Controllers\Api\V1\User\Transport\CurrenciesController@lookup');
        Route::get('/expense_codes','App\Http\Controllers\Api\V1\User\Transport\ExpenseCodesController@lookup');
        Route::get('/languages','App\Http\Controllers\Api\V1\User\Transport\LanguagesController@lookup');
        Route::get('/partners/{type}','App\Http\Controllers\Api\V1\User\Transport\PartnersController@lookup');
        Route::get('/partners_types','App\Http\Controllers\Api\V1\User\Transport\PartnersTypesController@lookup');
        Route::get('/revenue_codes','App\Http\Controllers\Api\V1\User\Transport\RevenueCodesController@lookup');     
        Route::get('/users','App\Http\Controllers\Api\V1\User\Transport\UsersController@lookup');  
        Route::get('/vehicles','App\Http\Controllers\Api\V1\User\Transport\VehiclesController@lookup');     
        Route::get('/vehicles_types','App\Http\Controllers\Api\V1\User\Transport\VehiclesTypesController@lookup');   

        #Exclusive
        Route::get('/documents_types','App\Http\Controllers\Api\V1\User\Transport\DocumentsTypesController@lookup');
        Route::get('/orders_masters_status','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersStatusController@lookup');
        Route::get('/orders_types','App\Http\Controllers\Api\V1\User\Transport\OrdersTypesController@lookup');
        Route::get('/pieces_units','App\Http\Controllers\Api\V1\User\Transport\PiecesUnitsController@lookup');            
        Route::get('/units','App\Http\Controllers\Api\V1\User\Transport\UnitsController@lookup');    

    });

    Route::prefix('user')->group(function () {
        
            Route::apiResource('/countries','App\Http\Controllers\Api\V1\User\Transport\CountriesController');
            Route::apiResource('/currencies','App\Http\Controllers\Api\V1\User\Transport\CurrenciesController');
            Route::apiResource('/expense_codes','App\Http\Controllers\Api\V1\User\Transport\ExpenseCodesController');        
            Route::apiResource('/languages','App\Http\Controllers\Api\V1\User\Transport\LanguagesController');  

            #Partners
            Route::get('/partners/contacts/{id}','App\Http\Controllers\Api\V1\User\Transport\PartnersContactsController@index');
            Route::apiResource('/partners_contacts','App\Http\Controllers\Api\V1\User\Transport\PartnersContactsController');
            Route::apiResource('/partners','App\Http\Controllers\Api\V1\User\Transport\PartnersController');
            Route::get('/partners/representatives/{id}','App\Http\Controllers\Api\V1\User\Transport\PartnersRepresentativesController@index');
            Route::apiResource('/partners_representatives','App\Http\Controllers\Api\V1\User\Transport\PartnersRepresentativesController');
            Route::apiResource('/partners_types','App\Http\Controllers\Api\V1\User\Transport\PartnersTypesController');

            #Me
            // Route::get('/me','App\Http\Controllers\Api\V1\User\Transport\ProfileController@show');

            Route::apiResource('/revenue_codes','App\Http\Controllers\Api\V1\User\Transport\RevenueCodesController');
            Route::apiResource('/users','App\Http\Controllers\Api\V1\User\Transport\UsersController');
            Route::apiResource('/vehicles','App\Http\Controllers\Api\V1\User\Transport\VehiclesController');
            Route::apiResource('/vehicles_types','App\Http\Controllers\Api\V1\User\Transport\VehiclesTypesController');

            #Exclusive
            Route::apiResource('/documents_types','App\Http\Controllers\Api\V1\User\Transport\DocumentsTypesController');

            ### Invoices
            Route::apiResource('/invoices','App\Http\Controllers\Api\V1\User\Transport\InvoicesController');
            Route::get('/invoices/details/{id}','App\Http\Controllers\Api\V1\User\Transport\InvoicesDetailsController@index');
            Route::apiResource('/invoices_details','App\Http\Controllers\Api\V1\User\Transport\InvoicesDetailsController');
            Route::get('/invoices/emails_attachments/{id}','App\Http\Controllers\Api\V1\User\Transport\InvoicesEmailsAttachmentsController@index');
            Route::apiResource('/invoices_emails_attachments','App\Http\Controllers\Api\V1\User\Transport\InvoicesEmailsAttachmentsController');
            Route::get('/invoices/settings/{id}','App\Http\Controllers\Api\V1\User\Transport\InvoicesSettingsController@index');
            Route::apiResource('/invoices_settings','App\Http\Controllers\Api\V1\User\Transport\InvoicesSettingsController');


            ### Orders
            Route::get('/orders/cmr_yellow_printed/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrYellowPrintedController@show');
            Route::post('/orders/cmr_yellow_printed/update','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrYellowPrintedController@update');
            Route::get('/orders/cmr_yellow_printed/download/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrYellowPrintedController@generate_pdf');  
            Route::get('/orders/cmr/form/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrController@display_form');
            Route::get('/orders/cmr/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrController@show');
            Route::post('/orders/cmr/update','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrController@update');
            Route::get('/orders/cmr/download/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersCmrController@generate_pdf');            
            Route::get('/orders/new/id','App\Http\Controllers\Api\V1\User\Transport\OrdersController@new_order_id');
            Route::apiResource('/orders','App\Http\Controllers\Api\V1\User\Transport\OrdersController');
            Route::post('/orders/files/upload','App\Http\Controllers\Api\V1\User\Transport\OrdersFilesController@update');
            Route::get('/orders/files/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersFilesController@index');
            Route::apiResource('/orders_files','App\Http\Controllers\Api\V1\User\Transport\OrdersFilesController');
            Route::get('/orders/goods/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersGoodsController@index');
            Route::apiResource('/orders_goods','App\Http\Controllers\Api\V1\User\Transport\OrdersGoodsController');
            Route::get('/orders_masters/new/id','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersController@get_new_order_id');
            Route::apiResource('/orders_masters','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersController');
            Route::get('/orders_masters/profits_expenses/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersProfitsExpensesController@index');
            Route::apiResource('/orders_masters_profits_expenses','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersProfitsExpensesController');
            Route::get('/orders_masters/profits_revenues/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersProfitsRevenuesController@index');
            Route::apiResource('/orders_masters_profits_revenues','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersProfitsRevenuesController');
            Route::apiResource('/orders_masters_status','App\Http\Controllers\Api\V1\User\Transport\OrdersMastersStatusController');
            Route::get('/orders/profits_expenses/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersProfitsExpensesController@index');
            Route::apiResource('/orders_profits_expenses','App\Http\Controllers\Api\V1\User\Transport\OrdersProfitsExpensesController');
            Route::get('/orders/profits_revenues/{id}','App\Http\Controllers\Api\V1\User\Transport\OrdersProfitsRevenuesController@index');
            Route::apiResource('/orders_profits_revenues','App\Http\Controllers\Api\V1\User\Transport\OrdersProfitsRevenuesController');
            Route::apiResource('/orders_types','App\Http\Controllers\Api\V1\User\Transport\OrdersTypesController');


            Route::apiResource('/pieces_units','App\Http\Controllers\Api\V1\User\Transport\PiecesUnitsController');
            Route::apiResource('/units','App\Http\Controllers\Api\V1\User\Transport\UnitsController');
    });

});
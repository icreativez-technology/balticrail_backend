<?php
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    
    Route::post('/register', 'App\Http\Controllers\Api\V1\Auth\Railway\RegisterController@register');
    Route::post('/login', 'App\Http\Controllers\Api\V1\Auth\Railway\LoginController@login');
    Route::post('/forgot_password', 'App\Http\Controllers\Api\V1\Auth\Railway\ForgotPasswordController@index');
    Route::post('/reset_password', 'App\Http\Controllers\Api\V1\Auth\Railway\ResetPasswordController@index');

});

Route::middleware(['auth:api'])->group(function () {

    #LookupTables  #FrontRoutes
    Route::prefix('front')->group(function () {
        
        Route::get('/countries','App\Http\Controllers\Api\V1\User\Railway\CountriesController@lookup');
        Route::get('/currencies','App\Http\Controllers\Api\V1\User\Railway\CurrenciesController@lookup');
        Route::get('/expense_codes','App\Http\Controllers\Api\V1\User\Railway\ExpenseCodesController@lookup');
        Route::get('/languages','App\Http\Controllers\Api\V1\User\Railway\LanguagesController@lookup');
        Route::get('/partners/{type}','App\Http\Controllers\Api\V1\User\Railway\PartnersController@lookup');
        Route::get('/partners_types','App\Http\Controllers\Api\V1\User\Railway\PartnersTypesController@lookup');
        Route::get('/revenue_codes','App\Http\Controllers\Api\V1\User\Railway\RevenueCodesController@lookup');     
        Route::get('/users','App\Http\Controllers\Api\V1\User\Railway\UsersController@lookup');  
        Route::get('/vehicles','App\Http\Controllers\Api\V1\User\Railway\VehiclesController@lookup');     
        Route::get('/vehicles_types','App\Http\Controllers\Api\V1\User\Railway\VehiclesTypesController@lookup');   

    });

    Route::prefix('user')->group(function () {
        
            Route::apiResource('/countries','App\Http\Controllers\Api\V1\User\Railway\CountriesController');
            Route::apiResource('/currencies','App\Http\Controllers\Api\V1\User\Railway\CurrenciesController');
            Route::apiResource('/expense_codes','App\Http\Controllers\Api\V1\User\Railway\ExpenseCodesController');        
            Route::apiResource('/languages','App\Http\Controllers\Api\V1\User\Railway\LanguagesController');  

            #Partners
            Route::get('/partners/contacts/{id}','App\Http\Controllers\Api\V1\User\Railway\PartnersContactsController@index');
            Route::apiResource('/partners_contacts','App\Http\Controllers\Api\V1\User\Railway\PartnersContactsController');
            Route::apiResource('/partners','App\Http\Controllers\Api\V1\User\Railway\PartnersController');
            Route::get('/partners/representatives/{id}','App\Http\Controllers\Api\V1\User\Railway\PartnersRepresentativesController@index');
            Route::apiResource('/partners_representatives','App\Http\Controllers\Api\V1\User\Railway\PartnersRepresentativesController');
            Route::apiResource('/partners_types','App\Http\Controllers\Api\V1\User\Railway\PartnersTypesController');

            #Me
            // Route::get('/me','App\Http\Controllers\Api\V1\User\Railway\ProfileController@show');

            Route::apiResource('/revenue_codes','App\Http\Controllers\Api\V1\User\Railway\RevenueCodesController');
            Route::apiResource('/users','App\Http\Controllers\Api\V1\User\Railway\UsersController');
            Route::apiResource('/vehicles','App\Http\Controllers\Api\V1\User\Railway\VehiclesController');
            Route::apiResource('/vehicles_types','App\Http\Controllers\Api\V1\User\Railway\VehiclesTypesController');
    });

});
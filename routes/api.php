<?php

use App\Models\ChartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Hemmy\SendSms\Controllers\HemmySendSms;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any("incoming", function(Request $request){
    ChartModel::addMail($request);
})->name("incominng_sms");

Route::any("emails", function(Request $request){
    return ChartModel::allMail()->get();
})->name("emails");

Route::any("email/{mail}", function(Request $request,$mail){
    return ChartModel::singleMail($mail)->get();
})->name("single_mail");


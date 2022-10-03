<?php

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
    Log::error("INCOMING",$request->all());
    $inbound = new \Postmark\Inbound($request->all());
    HemmySendSms::send("255685639653",$inbound->Subject());
})->name("incominng_sms");

// 9f674c94b72cd6f424dd50e6ec0739f2@inbound.postmarkapp.com
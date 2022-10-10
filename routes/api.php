<?php

use App\Http\Controllers\EmailController;
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
    return view("charts");
})->middleware("referer")->name("emails");

Route::any("mails", function(Request $request){
    $charts = ChartModel::allMail();
    if($request->search){
        $charts->where("OriginalMail","like","%".$request->search."%");
    }
    $charts = $charts->limit(10)->get();
    return view("mails",compact("charts"));
})->middleware("referer")->name("mails");

Route::any("email/{mail}", function(Request $request,$mail){
    $charts = ChartModel::singleMail($mail)->get();
    return view("chart_single",compact("charts","mail"));
})->middleware("referer")->name("single_mail");

Route::post("new-mail", [EmailController::class,"createNewMail"])->middleware("referer")->name("post-email");


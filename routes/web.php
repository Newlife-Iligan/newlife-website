<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::post('/zapier/enable', function (){
    return response()->json(['status' => 200]);
});
Route::post('/zapier/disable', function (){
    return response()->json(['status' => 200]);
});

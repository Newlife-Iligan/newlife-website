<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/zapier/enable', function (){
    return response()->json(['status' => 200]);
});
Route::get('/zapier/disable', function (){
    return response()->json(['status' => 200]);
});

Route::get('/zapier/data', function (){
    $inventories = \App\Models\Inventory::all();
    return response()->json(['status' => 200,'data' => $inventories]);
});

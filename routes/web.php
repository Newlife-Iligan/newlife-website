<?php

use App\Http\Controllers\FinanceController;
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
    return response($inventories)->header('Content-Type', 'text/plain');
});

Route::get('/api/zapier/docs', function (){
    $msg = "API Documentation to be added. Ongoing testing and setup in Zapier.";
    return response($msg)->header('Content-Type', 'text/plain');
});

Route::get('/finance/print/{id}', [FinanceController::class,'printForm'])->name('finance.print');

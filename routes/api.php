<?php

use Illuminate\Support\Facades\Route;

Route::get('/get-reminders-today', function (){
    $week_number = now()->weekOfMonth;
    $day_number = now()->dayOfWeek;

    dump($week_number, $day_number);
});
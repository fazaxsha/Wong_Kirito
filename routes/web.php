<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/ajax/get-coin-price', [CoinController::class, 'getPrice']);

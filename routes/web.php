<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::post('/upload',[SaleController::class,'upload']);

Route::get('/batch',[SaleController::class,'batch']);
Route::get('/dash', function () {
    return view('dashboard');
})->name('dashboard');



require __DIR__.'/auth.php'

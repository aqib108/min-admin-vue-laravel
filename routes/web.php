<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::prefix('')->middleware(['auth'])->group(function () {
    Route::get('/{any}', function () {
        return view('app'); // Use the name of your main Vue.js entry point or view
    })->where('any', '.*');  
});


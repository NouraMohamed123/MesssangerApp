<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\messengerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', [messengerController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/{id?}', [messengerController::class, 'index'])
    ->middleware('auth')
    ->name('messenger');
require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\JsonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/index', [JsonController::class, 'index'])->name('indexJSON');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::match(['get', 'post'],'/store', [JsonController::class, 'store'])->name('storeJSON');
    Route::match(['get', 'post'],'/edit/{id}', [JsonController::class, 'edit'])->name('editJSON');
    Route::patch('/update/{id}', [JsonController::class, 'update'])->name('updateJSON');
    Route::delete('/delete/{id}', [JsonController::class, 'destroy'])->name('deleteJSON');
});



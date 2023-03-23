<?php

use Illuminate\Support\Facades\Route;
use Kaira\Infrastructure\Ui\Http\Url\SortUrls\ShortUrlsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/short-urls', ShortUrlsController::class);

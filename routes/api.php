<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ImageGalleryController;
use App\Http\Controllers\VideoGalleryController;
use Illuminate\Support\Facades\Route;

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

Route::apiResources([
    'imgGallery' => ImageGalleryController::class,
    'videoGallery' => VideoGalleryController::class
]);

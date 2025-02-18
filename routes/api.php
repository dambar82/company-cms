<?php

use App\Http\Controllers\AbubakirovController;
use App\Http\Controllers\AminaController;
use App\Http\Controllers\MDTController;
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

Route::prefix('amina')->group( function () {
    Route::get('audio', [AminaController::class, 'getAudios']);
    Route::get('audio/{id}', [AminaController::class, 'getAudio']);
    Route::get('news', [AminaController::class, 'getAllNews']);
    Route::get('news/{id}', [AminaController::class, 'getNews']);
    Route::get('video', [AminaController::class, 'getVideos']);
    Route::get('video/{id}', [AminaController::class, 'getVideo']);
});

Route::prefix('abubakirov')->group( function () {
    Route::get('image-gallery', [AbubakirovController::class, 'getAllImageGallery']);
    Route::get('image-gallery/{id}', [AbubakirovController::class, 'getImageGallery']);
    Route::get('video-gallery', [AbubakirovController::class, 'getVideos']);
    Route::get('video-gallery/{id}', [AbubakirovController::class, 'getVideo']);
});

Route::prefix('master_dig_tech')->group( function () {
    Route::get('videos', [MDTController::class, 'getVideos']);
    Route::get('videos/{id}', [MDTController::class, 'getVideo']);
    Route::get('services', [MDTController::class, 'getServices']);
    Route::get('services/{id}', [MDTController::class, 'getService']);
//    Route::get('images', [MDTController::class, 'getImages']);
    Route::get('images/{id}', [MDTController::class, 'getImage']);
});

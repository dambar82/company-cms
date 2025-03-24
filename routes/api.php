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
    Route::post('add_feedback', [AminaController::class, 'addFeedback']);
});

Route::prefix('abubakirov')->group( function () {
    Route::get('image-gallery', [AbubakirovController::class, 'getAllImageGallery']);
    Route::get('image-gallery/{id}', [AbubakirovController::class, 'getImageGallery']);
    Route::get('video-gallery', [AbubakirovController::class, 'getVideos']);
    Route::get('video-gallery/{id}', [AbubakirovController::class, 'getVideo']);
});

Route::prefix('master_dig_tech')->group( function () {
    Route::get('services', [MDTController::class, 'getServices']);
    Route::get('services/{service_slug}', [MDTController::class, 'getServiceBySlug']);
    Route::get('services/{service_slug}/{category_slug}', [MDTController::class, 'getContent']);
    Route::get('categories', [MDTController::class, 'getCategories']);
    Route::get('categories/{service_slug}', [MDTController::class, 'getCategoriesByServiceSlug']);
    Route::post('send_request', [MDTController::class, 'sendRequest']);
});

<?php

use App\Http\Controllers\create\ConversionController;
use App\Http\Controllers\youtube\YoutubeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('/process', [YoutubeController::class, 'processVideo'])->name('process');

    Route::group([
        'prefix' => '/create',
        'as' => 'create'
    ], function () {

        Route::get('/blog', [ConversionController::class, 'createBlogPost'])->name('blog');

        Route::get('/social', [ConversionController::class, 'createSocialPost'])->name('social');

        Route::get('/reels', [ConversionController::class, 'createReels'])->name('reels');

    });
});

<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CrawlController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StarController;
use App\Http\Controllers\Admin\StoryController;
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

Route::get('/auth/{provider}', [UserController::class, 'redirectToProvider'])->name('auth.provider');
Route::get('/auth/{provide}/callback', [UserController::class, 'handleProviderCallback']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login1');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//    Route::as('password.')->group(function () {
//        Route::get('reset-password', [ResetPasswordController::class, 'showResetForm'])->name('reset.index');
//        Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('reset.update');
//    });
//    Route::get('edit-user', [ResetPasswordController::class, 'edit'])->name('reset.edit');
//    Route::post('update-user', [ResetPasswordController::class, 'update'])->name('reset.update');


    Route::resource('roles', RoleController::class)->except('show', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('permissions', PermissionController::class)->except('show', 'create', 'store', 'destroy');
    Route::get('permissions/reset', [PermissionController::class, 'resetCache'])->name('permissions.reset');
    //
    Route::resource('users', UserController::class)->except('show');
    Route::post('users/switch/change', [UserController::class, 'switchUserChange'])->name('users.switch.change');
    Route::get('users/switch/back/{user}', [UserController::class, 'switchUserBack'])->name('users.switch.back');
    Route::get('users/switch/{user}', [UserController::class, 'switchUser'])->name('users.switch');
    //
//    Route::resource('products', ProductController::class)->except('show', 'destroy');
    Route::get('crawl', [CrawlController::class, 'index'])->name('crawl.index');
    Route::post('crawl', [CrawlController::class, 'store'])->name('crawl.store');

    Route::resource('author', AuthorController::class)->except('show');
    Route::resource('category', CategoryController::class)->except('show');
    Route::resource('story', StoryController::class);
    Route::post('story/update-attribute/{id}', [StoryController::class, 'updateAttribute'])->name('story.update.attribute');
    Route::post('stars', [StarController::class, 'updateSingle'])->name('stars.update');
    Route::resource('chapter', ChapterController::class)->except('show');
    Route::get('{story_id}/chapter/create', [ChapterController::class, 'create'])->name('chapter.create');

    // Route::resource('rating', RatingController::class);    
    Route::get('rating', [RatingController::class, 'index'])->name('rating.index');
    Route::post('rating', [RatingController::class, 'update'])->name('rating.update');

    Route::get('/settings', [SettingsController::class, 'index'])->name('display.index');
    Route::post('/update', [SettingsController::class, 'update'])->name('display.update');
    // Route::resource('rating')
});
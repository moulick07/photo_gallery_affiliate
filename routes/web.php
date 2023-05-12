<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RegisterController;
use Illuminate\Support\Facades\Log;

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

Route::get('/', [PhotoController::class, 'index'])->name('welcome.guest');




Route::get('home', [HomeController::class, 'index'])->name('index');

Auth::routes();

Route::group(['middleware' => ['auth', 'isAdmin']], function () {

    Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
    Route::get('/welcomepage', [PhotoController::class, 'index'])->name('welcome.page');

});
Route::get('/create', [PhotoController::class, 'index'])->name('create');
Route::get('/create-photo', [PhotoController::class, 'create'])->name('create.photo');
Route::post('/add-photo', [PhotoController::class, 'store'])->name('store.photo');
Route::get('/search-user', [HomeController::class, 'search'])->name('search.user');
Route::get('/show/{id}', [PhotoController::class, 'show'])->name('show');
Route::delete('/show/delete/{id}', [PhotoController::class, 'destroy'])->name('delete');
Route::get('/edit', [PhotoController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [PhotoController::class, 'update'])->name('update');
Route::get('/purchase/{id}', [PhotoController::class, 'wallet'])->name('wallet');
Route::post('/update-coins', [HomeController::class, 'change'])->name('change');
Route::get('/update-amount/{id}', [HomeController::class, 'update'])->name('updatecoins');
Route::get('/transaction/{id}', [PhotoController::class, 'transaction'])->name('transaction');
Route::get('/download/{id}', [PhotoController::class, 'download'])->name('download');
Route::get('/transactions', [HomeController::class, 'transact'])->name('transact');
Route::get('/search', [PhotoController::class, 'search'])->name('search');
Route::get('/imageview',[HomeController::class, 'imagepage'])->name('imagePage');
Route::get('/deleteByAdmin/{id}',[HomeController::class, 'imagedelete'])->name('deletebyadmin');


Route::get('/logout', function(){
        Auth::logout();
        return Redirect::to('login');
     })->name('logout.user');

// Route::post('logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);
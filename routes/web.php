<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PhotoController;

use App\Http\Controllers\AdminController;
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





Auth::routes();

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::get('home', [AdminController::class, 'index'])->name('index');

    
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/search-user', [AdminController::class, 'search'])->name('search.user');
    Route::get('/welcomepage', [PhotoController::class, 'index'])->name('welcome.page');
    Route::post('/update-coins', [AdminController::class, 'change'])->name('change');
    Route::get('/update-amount/{id}', [AdminController::class, 'update'])->name('updatecoins');
    Route::get('/transactions', [AdminController::class, 'transact'])->name('transact');
    Route::get('/imageview',[AdminController::class, 'imagepage'])->name('imagePage');
    Route::get('/deleteByAdmin/{id}',[AdminController::class, 'imagedelete'])->name('deletebyadmin');
});



Route::get('/create-photo', [PhotoController::class, 'create'])->name('create.photo');
Route::get('/create', [PhotoController::class, 'index'])->name('create');
Route::post('/add-photo', [PhotoController::class, 'store'])->name('store.photo');
Route::get('/show/{id}', [PhotoController::class, 'show'])->name('show');
Route::delete('/show/delete/{id}', [PhotoController::class, 'destroy'])->name('delete');
Route::get('/edit', [PhotoController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [PhotoController::class, 'update'])->name('update');
Route::get('/purchase/{id}', [PhotoController::class, 'wallet'])->name('wallet');
Route::get('/transaction/{id}', [PhotoController::class, 'transaction'])->name('transaction');
Route::get('/download/{id}', [PhotoController::class, 'download'])->name('download');
Route::get('/search', [PhotoController::class, 'search'])->name('search');


Route::get('/logout', function(){
        Auth::logout();
        return Redirect::to('login');
     })->name('logout.user');

// Route::post('logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);


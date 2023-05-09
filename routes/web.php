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


// Route::get('/demo', function () {
//     return view('demo');
//  });
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//  Route::middleware(['auth', 'isAdmin'])->group(function () {
// Route::get('/admin', function () {
//   return view('welcomee');
// })->name('dashboard');

// Auth::routes();

// Route::post('/posts',[MarketController::class,'store'])->name('store');
// Route::get('/', function () {
//     return view('auth.login');
// }); 

// }); 




// Route::get('welcome-page',[PhotoController::class,'index']);

Route::get('home', [HomeController::class, 'index'])->name('index');
// Route::get('/addphoto/{$id}',[App\Http\Controllers\MarketController::class, 'show'])->name('addphoto.show');
Auth::routes();
// Route::get('/welcome', [App\Http\Controllers\MarketController::class, 'index'])->name('welcome');
// Route::post('/register', [RegisterController::class, 'create'])->name('register');
// Route::get('show/{$id}', [App\Http\Controllers\HomeController::class, 'show'])->name('show');

// Route::resource('user', UserController::class);
// Route::get('addphoto/{$id}', [MarketController::class,'show'])->name('addphoto');
Route::group(['middleware' => ['auth', 'isAdmin']], function () {

    Route::get('/welcomepage', [PhotoController::class, 'index'])->name('welcome.page');
    Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');

});
Route::get('/create', [PhotoController::class, 'index'])->name('create');
Route::get('/create-photo', [PhotoController::class, 'create'])->name('create.photo');
Route::post('/add-photo', [PhotoController::class, 'store'])->name('store.photo');
Route::get('/search-user', [HomeController::class, 'search'])->name('search.user');
Route::get('/show/{id}', [PhotoController::class, 'show'])->name('show');
Route::delete('/show/delete/{id}', [PhotoController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [PhotoController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [PhotoController::class, 'update'])->name('update');
Route::get('/purchase/{id}', [PhotoController::class, 'wallet'])->name('wallet');
Route::get('/update-coins/{id}', [HomeController::class, 'change'])->name('change');
Route::get('/update-amount/{id}', [HomeController::class, 'update'])->name('updatecoins');
Route::get('/transaction/{id}', [PhotoController::class, 'transaction'])->name('transaction');
Route::get('/download/{id}', [PhotoController::class, 'download'])->name('download');
Route::get('/transactions', [HomeController::class, 'transact'])->name('transact');
Route::get('/search', [PhotoController::class, 'search'])->name('search');
// Route::get('/sortbyhightolow/{price}', [PhotoController::class, 'products'])->name('descsort');
// Route::get('/sortbylowtohigh/{price}', [PhotoController::class, 'products'])->name('ascsort');
// Route::get('/sortbyatoz/{title}', [PhotoController::class, 'products'])->name('nameatoz');
// Route::get('/sortbyztoa/{title}', [PhotoController::class, 'products'])->name('nameztoa');



// Route::get('buy/{cookies}', function ($cookies) {
//     $wallet = Auth::user()->wallet;
//     Auth::user()->update(['wallet' => auth::user()->wallet - $cookies * 1]);
//     // dd( Auth::user()->wallet );
//     Log:info(['User ' . Auth::user()->name . ' have bought ' . $cookies . ' cookies']); // we need to log who ordered and how much
//     return 'Success, you have bought ' . $cookies . ' cookies!';

// });

Route::get('/logout', function(){
        Auth::logout();
        return Redirect::to('login');
     })->name('logout.user');

// Route::post('logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);
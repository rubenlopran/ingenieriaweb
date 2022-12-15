<?php

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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleSocialiteController;
 
 
Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback']);
Route::get('/', function () {
    return view('menu');
})->middleware('auth');
Route::get('/mapa', function () {
    return view('maps.index');
})->name('mapa')->middleware('auth');


Route::get('/cercanos', 'LugaresCercanosController@getData')->name('cercanos');
Route::get('/AdvertisementMap', 'LocationController@index')->name('AdvertisementMap');
Route::get('/localizacion', 'GeocodeController@getData')->name('localizacion');
Route::get('/meteo/hourly', 'MeteorologiaController@getDataHourly')->name('meteorologia horaria');
Route::get('/meteo/daily', 'MeteorologiaController@getDataDaily')->name('meteorologia diaria');
Route::get('/maps', 'MapsController@index')->name('maps');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::post('/iniciosesion', 'InicioSesion@login')->name('iniciosesion');
Route::post('/logout', 'InicioSesion@logout')->name('logout')->middleware('auth');
Route::get('/menu', 'MenuController@index')->name('menu')->middleware('auth');


Route::resource('posts', PostController::class)->middleware('auth');
Route::resource('advertisement', AdvertisementController::class)->middleware('auth');
Route::resource('booking', BookingController::class)->middleware('auth');
Route::resource('location', LocationController::class);
Route::resource('publicacions', PublicacionController::class)->middleware('auth');
Route::resource('likes', LikeController::class)->middleware('auth');
Route::resource('songs', SongController::class)->middleware('auth');


Route::post('/almazara/show', 'BookingController@show')->name('almazara.show')->middleware('auth');

Route::post('/booking/create', 'BookingController@create')->name('booking.create')->middleware('auth');
Route::get('/myadvs', 'AdvertisementController@myadvs')->name('advertisement.myadvs')->middleware('auth');


Route::get('/anuncios', 'AdvertisementController@rest')->name('advertisement.anuncios');

Route::get('/pagar', 'PaymentController@index');
// route for processing payment
Route::post('paypal', 'PaymentController@payWithpaypal');

// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus');

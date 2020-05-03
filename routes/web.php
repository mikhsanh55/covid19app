<?php

use Illuminate\Support\Facades\Route;

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

// Get View using Get Method

Route::get('/book-list/{id?}', function ($id = 2) {
	return view('book_list', [
		'order_no' => $id,
		'book' => 'Laravel Book'
	]);
});

// Home Route
Route::redirect('/', '/home');
Route::get('home/kontak', 'ContainerController@kontak');
Route::get('home/get-coordinates', 'ContainerController@get_all_coordinates');
Route::get('home/get-data-chart', 'ContainerController@get_data_chart');

Auth::routes();
Route::get('home', 'ContainerController@index')->name('home');
// Route::get('home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {

	// Employee Route ( Test )
	Route::get('employee', 'EmployeeController@index');
	Route::view('employee/add', 'employee/add');
	Route::post('employee/insert', 'EmployeeController@insert');

	// User Route ( Test )
	Route::get('user', 'UserController@index');
	Route::view('user/add', 'user/add');
	Route::get('user/edit/{id}', 'UserController@edit');
	Route::get('user/hapus/{id}', 'UserController@hapus');
	// // user Route Logic
	Route::post('user/insert', 'UserController@insert');
	Route::put('user/update', 'UserController@update');

	// Pasien Route
	Route::redirect('pasien', 'pasien/add');
	Route::get('pasien/add', 'PasienController@add');
	Route::post('pasien/insert', 'PasienController@insert');
	Route::get('pasien/edit/{id}', 'PasienController@edit');
	Route::get('pasien/detail/{id}', 'PasienController@detail');
	Route::post('pasien/update', 'PasienController@update');
	Route::post('pasien/delete', 'PasienController@delete');
	Route::get('pasien/data', 'PasienController@data');
	Route::post('pasien/data-filter', 'PasienController@filter_data');
	Route::post('pasien/data-detail-filter', 'PasienController@filter_detail_data');
	Route::post('pasien/import', 'PasienController@importCsv');

	// Wilayah Route
	Route::get('/kecamatan/get-by-kota/{id}', 'Wilayah\Kecamatan@get_kecamatan_by_kota');
	Route::get('/kelurahan/get-by-kecamatan/{id}', 'Wilayah\Kelurahan@get_kelurahan_by_kecamatan');

	// No Darurat
	Route::get('/no-darurat', 'NoDaruratController@index');
	Route::post('/no-darurat/insert', 'NoDaruratController@insert');
	Route::get('/no-darurat/detail/{id}', 'NoDaruratController@detail');
	Route::post('/no-darurat/update', 'NoDaruratController@update');
	Route::post('/no-darurat/delete', 'NoDaruratController@delete');

	// Rumah Sakit Rujukan
	Route::get('/rumah-sakit-rujukan', 'RumahSakitController@index');
	Route::get('/rumah-sakit', 'RumahSakitController@rumah_sakit');
	Route::post('/rumah-sakit/insert', 'RumahSakitController@insert');
	Route::get('/rumah-sakit/detail/{id}', 'RumahSakitController@detail');
	Route::post('/rumah-sakit/update', 'RumahSakitController@update');
	Route::post('/rumah-sakit/delete', 'RumahSakitController@delete');

	// Kontak
	Route::get('/kontak', 'KontakController@index');
	Route::post('/kontak/insert', 'KontakController@insert');
	Route::get('/kontak/detail/{id}', 'KontakController@detail');
	Route::post('/kontak/update', 'KontakController@update');
	Route::post('/kontak/delete', 'KontakController@delete');

	// Slider
	Route::get('/slider', 'SliderController@index');
	Route::post('/slider/insert', 'SliderController@insert');
	Route::get('/slider/detail/{id}', 'SliderController@detail');
	Route::post('/slider/update', 'SliderController@update');
	Route::post('/slider/delete', 'SliderController@delete');
});
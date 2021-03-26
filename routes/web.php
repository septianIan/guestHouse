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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/test', function(){
    return view('test');
});


// Auth::routes();
Route::post('login', 'Auth\LoginController@login');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Chart Plan
 * 
 */
Route::get('date-between', 'Chart\ChartPlanController@betweenDate')->name('chartPlan.dateBetween');
Route::get('reservation/plan', 'Chart\SchedulerController@reservationPlan')->name('chartPlan.reservationPlan');

Route::get('chartplan/today/expected/arrivale', 'Chart\SchedulerController@todayEAList')->name('chartPlan.todayEAList');
Route::get('data/today/expected/arrival', 'Chart\SchedulerController@dtTodayEA')->name('data.todayEA');

Route::get('chartplan/today/expected/departure', 'Chart\SchedulerController@todayEDList')->name('chartPlan.todayEDList');
Route::get('data/today/expected/departure', 'Chart\SchedulerController@dtTodayED')->name('data.todayEDList');

Route::get('data/rooms', 'Chart\SchedulerController@rooms')->name('data.rooms');


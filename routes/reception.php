<?php 

Route::get('/', function () {
   return view('frontOffice.reception.index');
})->name('reception');
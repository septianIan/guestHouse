<?php

use App\Reservation;

Route::get('/', function () {
   $reservation = Reservation::where('status', 0)->get();
   $reservationReserved = Reservation::where('status', 1)->get();
   return view('frontOffice.reservation.home', 
   compact('reservation', 'reservationReserved'));
})->name('dashboard');

//REGISTRATION
Route::resource('/registration', 'RegistrationController');
Route::get('data/registration', 'DataTable\DataTableRegistration')->name('data.registrations');
Route::get('deleteRoomArragement/{id}', 'RegistrationController@deleteRoomArragement')->name('registration.deleteRoomArragement');
Route::post('/registration/editRoom/{id}', 'RegistrationController@editRoom')->name('registration.editRoom');
Route::post('/registration/addRoom', 'RegistrationController@addRoom')->name('registration.addRoom');
Route::post('/registration/editExtraBad/{id}', 'RegistrationController@editExtraBad')->name('registration.editExtraBad');
Route::get('deleteExtraBad/{id}', 'RegistrationController@deleteExtrabad')->name('regsitration.deleteExtraBad');
Route::post('/registration/addExtraBad', 'RegistrationController@addExtraBad')->name('registration.addExtraBad');


/**
 * Individual Check In
 */
Route::get('/data/individualCheckIn', 'CheckInController@index')->name('checkIn.individualCheckIn');
Route::get('data/reservation', 'CheckInController@dataTableIndividualReservation')->name('data.IndividualReservations');
Route::get('/checkIn/{id}', 'CheckInController@checkIn')->name('checkIn.checkInStore');

Route::get('detailIndividualCheckIn/{id}', 'CheckInController@detailIndividualReservation')->name('data.detailReservation');
//BATAS



/**
 * Group Check In
 */
Route::get('/groupCheckIn', 'CheckInController@indexGroup')->name('checkIn.groupCheckIn');
Route::get('/data/groupReservation', 'CheckInController@dataTableGroupReservation')->name('data.groupReservations');
Route::get('/detailGroupCheckIn/{id}', 'CheckInController@detailGroupReservation');

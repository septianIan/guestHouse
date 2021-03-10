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
Route::post('/registration/addExtraBed', 'RegistrationController@addExtraBed')->name('registration.addExtraBed');


/**
 * Individual Check In
 */
Route::get('/data/individualCheckIn', 'CheckInController@index')->name('checkIn.individualCheckIn');
Route::get('data/reservation', 'CheckInController@dataTableIndividualReservation')->name('data.IndividualReservations');
Route::get('detailIndividualCheckIn/{id}', 'CheckInController@detailIndividualReservation')->name('data.detailReservation');
//BATAS

//route check in
Route::get('/checkIn/{id}', 'CheckInController@checkIn')->name('checkIn.checkInStore');



/**
 * Group Check In
 */
Route::get('/groupCheckIn', 'CheckInController@indexGroup')->name('checkIn.groupCheckIn');
Route::get('/data/groupReservation', 'CheckInController@dataTableGroupReservation')->name('data.groupReservations');
Route::get('/detailGroupCheckIn/{id}', 'CheckInController@detailGroupReservation');

/**
 * Casshier
 */
Route::get('guest/checkIn', 'CashierController@index')->name('cashier.index');
Route::get('data/guest/checkIn', 'CashierController@dtGuestCheckIn')->name('data.guestCheckIn');
Route::get('guest/checkIn/detail/{id}', 'CashierController@detailGuetsCheckIn')->name('cashier.detailGuetsCheckIn');

/**
 * Voucher/Bill telephone
 */
Route::post('guest/bill/telephone', 'vouchers\TelephoneVoucherController@store')->name('billTelephone.store');
Route::get('/guest/billtelephonne/edit/{id}', 'vouchers\TelephoneVoucherController@edit')->name('billtelephone.edit');
Route::post('guest/bill/telephone/update', 'vouchers\TelephoneVoucherController@update')->name('billtelephone.update');
Route::delete('guest/bill/telephone/delete/{id}', 'vouchers\TelephoneVoucherController@destroy')->name('billtelephone.destroy');

/**
 * Voucher / bill miscella
 */
Route::post('guest/bill/miscellaneous', 'vouchers\MiscellaneousVoucherController@store')->name('billMiscellaneous.store');
Route::get('/guest/billMiscellaneous/edit/{id}', 'vouchers\MiscellaneousVoucherController@edit');
Route::post('guest/bill/miscellaneous/update', 'vouchers\MiscellaneousVoucherController@update')->name('billMicellaneous.update');
Route::delete('guest/bill/miscellaneous/delete/{id}', 'vouchers\MiscellaneousVoucherController@destroy')->name('billMiscellaneous.destroy');
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

//check erly arrivale
Route::get('/check/early/arrival/{id}', 'CheckInController@checkEarlyArrivale');
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

Route::post('guest/bill', 'bill\GuestBillController@store')->name('guestBill.store');
//delete postbill
Route::delete('guest/bill/delete/description/{id}', 'bill\GuestBillController@destroy')->name('guestBill.destroy');

//MASTER BILL
Route::resource('master-bill', 'bill\MasterBillController');
//delete masterbill
Route::delete('guest/bill/delete/master-bill/{id}', 'bill\MasterBillController@deleteMasterBill')->name('guestBill.deleteMasterBill');
//delete masterbill per kamar
Route::delete('guest/bill/delete/master-bill/per-room/{id}', 'bill\MasterBillController@deleteMasterBillPerRoom');

// Temporary bill
Route::get('temporary/bill', 'bill\TemporaryBillController@guestBills')->name('temporary.bill');
Route::post('temporary/create/all-bills', 'bill\TemporaryBillController@saveAllBills')->name('temporary.store');

//!RESET ALL BILL
Route::get('guest/bill/reset/{id}', 'bill\TemporaryBillController@resetAllBill');

//!check early departure
ROute::get('check/early/departure/{id}', 'bill\CheckOutController@checkEarlyDeparture');
//!CheckOut
Route::get('guest/bill/checkout/{id}', 'bill\CheckOutController@checkOut');
Route::get('guest/bill/checkout/detail/{id}', 'bill\CheckOutController@checkOutDetail')->name('checkOut.detail');

// *print voucher bill
Route::get('bill/voucher/guest/{id}', 'bill\MasterBillController@printVoucher')->name('masterBill.voucher');

//!
Route::post('check/registration/room/reserved', 'RegistrationController@cekRoom')->name('checkAvailableRoom.totalRoomReserved');
Route::post('check/room/reserved', 'CheckInController@cekRoom')->name('checkAvailableRoom.roomReserved');

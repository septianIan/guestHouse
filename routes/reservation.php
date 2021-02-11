<?php

use App\Reservation;
use App\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   $reservation = Reservation::where('status', 0)->get();
   $reservationReserved = Reservation::where('status', 1)->get();
   return view('frontOffice.reservation.home', 
   compact('reservation', 'reservationReserved'));
})->name('dashboard');

Route::resource('reservation', 'ReservationGuestController');
Route::get('cancelGuest', 'ReservationGuestController@cancelGuest')->name('reservation.cancelGuest');
Route::get('cancelGroup', 'ReservationGroupController@cancelGroup')->name('reservation.cancelGroup');

//dataTable NON GROUP
Route::get('data/reservation', 'DataTable\DataTableReservation')->name('data.reservations');
Route::get('data/cancelReservation', 'DataTable\DataTableCancelGuestReservation')->name('data.cancelReservations');

Route::get('deleteRoomArragement/{id}', 'ReservationGuestController@deleteRoomArragement')->name('deleteRoomArragement.room');
Route::get('reservation/detailCancelReservation/{id}', 'ReservationGuestController@detailCancelReservation');



/**
 * GROUP RESERVATION
 */
Route::resource('reservationGroup', 'ReservationGroupController');
Route::get('data/reservationGroup', 'DataTable\DataTableReservationGroupController')->name('data.reservationGroups');
Route::get('data/cancelReservationGroup', 'DataTable\DataTableCancelGroup')->name('data.cancelReservationGroups');
Route::get('reservation/detailCancelReservationGroup/{id}','ReservationGroupController@detailCancelReservationGroup');
Route::get('reservationGroup/deteleRoomArragement/{id}', 'ReservationGroupController@deleteRoomArragementGroupReservation')->name('deteleRoomArragement.room');
Route::get('reservationGroup/deleteMealArragementGroupReservation/{id}', 'ReservationGroupController@deleteMeal')->name('deleteMealArragementGroupReservation.room');


/**
 * Request jquery
 */
Route::post('roomRate', 'ReservationGuestController@searchRoomRate')->name('search.roomRate');

Route::post('checkAvailableRoom/standart', 'ReservationGuestController@checkRoomStandart')->name('checkAvailableRoomStandart.totalRoomReserved');

Route::post('checkAvailableRoom/superior', 'ReservationGuestController@checkRoomSuperior')->name('checkAvailableRoomSuperior.totalRoomReserved');

Route::post('checkAvailableRoom/deluxe', 'ReservationGuestController@checkRoomDeluxe')->name('checkAvailableRoomDeluxe.totalRoomReserved');

//Tambah kamar baru
Route::post('checkAvailableRoom', 'ReservationGuestController@checkAvailableRoom')->name('checkAvailableRoom.totalRoomReserved');

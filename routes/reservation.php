<?php

use App\Reservation;
use App\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   $reservation = Reservation::where('status', 0)->get();
   $reservationReserved = Reservation::where('status', 1)->get();
   return view('frontOffice.reservation.home', 
   compact('reservation', 'reservationReserved'));
});

Route::resource('reservation', 'ReservationGuestController');
Route::resource('reservationGroup', 'ReservationGroupController');
Route::get('calendar', 'CalendarController@index')->name('calender.index');

//dataTable
Route::get('data/reservation', 'DataTable\DataTableReservation')->name('data.reservations');
Route::get('editRoom/{id}', 'ReservationGuestController@deleteRoom')->name('edit.room');
Route::get('addNewRoom/{id}', 'ReservationGuestController@addNewRoom')->name('addNew.room');

//data table 
Route::get('data/reservationGroup', 'DataTable\DataTableReservationGroupController')->name('data.reservationGroups');
Route::get('reservationGroup/deleteMeal/{id}', 'ReservationGroupController@deleteMeal')->name('deleteMeal.meal');
Route::post('reservationGroup/addMeal', 'ReservationGroupController@addMeal')->name('addMeal.meal');
Route::get('reservationGroup/deteleRoom/{id}', 'ReservationGroupController@deleteRoom')->name('deleteRoom.room');
Route::post('reservationGroup/addRoom', 'ReservationGroupController@addRoom')->name('addRoom.room');




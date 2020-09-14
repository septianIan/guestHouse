@extends('frontOffice.template.ui')
@section('title', 'Dashboard')

@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
         <div class="info-box">
            <span class="info-box-icon bg-success"><i class="far fa-user"></i></span>

            <div class="info-box-content">
               <span class="info-box-text">Nor Reserved</span>
               <span class="info-box-number">{{ $reservation->count() }}</span>
            </div>
         </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
         <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>

            <div class="info-box-content">
               <span class="info-box-text">Guest Reserved</span>
               <span class="info-box-number">{{ $reservationReserved->count() }}</span>
            </div>
         </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
         <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
               <span class="info-box-text">Nor Reserved</span>
               <span class="info-box-number">{{ $reservation->count() }}</span>
            </div>
         </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
         <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="far fa-user"></i></span>

            <div class="info-box-content">
               <span class="info-box-text">Nor Reserved</span>
               <span class="info-box-number">{{ $reservation->count() }}</span>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      
   </div>
   
</div>
@endsection

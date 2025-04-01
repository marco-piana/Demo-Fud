@extends('layouts.appbsvue', ['title' => __('Reservations'), 'hideActions'=>true ])
@section('content')
    <div class="col-12">
        @include('partials.flash')
    </div>
    <div class="container-fluid mt-4" id="reservation_panel">
        @include('tablereservations::panel.topactions')
        @include('tablereservations::panel.reservations')
    </div>
</div>
@include('tablereservations::panel.scripts')
@endsection

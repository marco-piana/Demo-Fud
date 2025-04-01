@extends('cards::layouts.master')
@section('content')
    @include('cards::landing.header')
     <!-- Featured clients -->
     @if(in_array("feautureclients", config('global.modules',[])))
        @includeIf('feautureclients::loyalty')
    @endif
    @include('cards::landing.features')
    @if ($isExtended)
        @include('cards::landing.pricing')
    @endif
    @include('cards::landing.faq')
    @include('cards::landing.footer')
@endsection
@extends('cards::layouts.master')
@section('title')
    <title>{{ $company->name }}</title>
@endsection
@section('content')
    @include('cards::company.partials.header')
    @include('cards::company.partials.awards')
    @include('cards::company.partials.faq')
    @include('cards::company.partials.footer')
@endsection
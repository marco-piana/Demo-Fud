<!-- remove points -->
@extends('layouts.app', ['title' => __('Remove points')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Get an award') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('partials.flash')
                </div>
                <div class="card-footer py-4">
                    <form action="{{ route('loyalty.remove') }}" class="" id="givePoints" method="POST">
                        @csrf

                        <!-- Show user selector -->
                        @include('partials.fields', $userFields)
                        <hr />
                        <!-- Show categories values entering -->
                        <button type="submit" class="btn btn-success mt-4">
                            {{ __('Get award') }}
                        </button>
                    </form>
                   

                </div>

            </div>

           

        </div>
    </div>
</div>

@endsection
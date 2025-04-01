@extends('layouts.app', ['title' => __('loyalty.give_points')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('loyalty.give_points') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('partials.flash')
                </div>
                <div class="card-footer py-4">
                    <form action="{{ route('loyalty.give') }}" class="" id="givePoints" method="POST">
                        @csrf

                        <!-- Show user selector -->
                        @include('partials.fields', $userFields)
                        <hr />
                        <!-- Show categories values entering -->
                        <button type="submit" class="btn btn-success mt-4">
                            {{ __('loyalty.give_points') }}
                        </button>
                    </form>
                   

                </div>

            </div>

           

        </div>

        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('loyalty.point_rules') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('partials.flash')
                </div>
                <div class="card-footer py-4">
                    <form id="calculateForm" method="POST">
                        @csrf
                        <input type="hidden" name="vendor_id" value="{{ $vendor->id }}" />
                        @foreach ($categories as $category)
                            <h3>{{ $category->name}}</h3>
                            <p>{{__('loyalty.percent_of_value')}}:{{ $category->percent}}%<br />
                                {{__('loyalty.static_points')}}:{{ $category->staticpoints}} -- {{__('loyalty.static_points_threshold')}}:{{ $category->threshold}}<br />
                                
                            </p>
                            <!-- order value input -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="orderValueCategory" class="form-control-label">{{__('loyalty.order_value_per_category')}}</label>
                                    <input type="number" name="orders_per_categories[{{ $category->id}}]" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="orderValue" class="form-control-label">{{__('loyalty.points')}}</label>
                                    <input type="number" readonly name="per_category_points_{{ $category->id}}" class="form-control">
                                </div>
                            </div>
                            <hr />
                        @endforeach

                        <div class="row">
                            <div class="col-md-6">
                                <label for="orderValue"  class="form-control-label">{{__('loyalty.order_value')}}</label>
                                <input type="number" readonly name="orderValue" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="orderPoints" class="form-control-label">{{__('loyalty.points')}}</label>
                                <input type="number" readonly name="orderPoints" class="form-control">
                            </div>
                        </div>

                        <hr />
                        <!-- Show categories values entering -->
                        <button type="submit" class="btn btn-success mt-4">
                            {{ __('loyalty.calculate_points') }}
                        </button>
                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    setTimeout(() => {
    $(document).ready(function(){
        $('#calculateForm').submit(function(e){
            e.preventDefault();
            var formData = $('#calculateForm').serialize();

    
            console.log(formData);
            $.post('/loyalty/calculate', formData, function(response){
                // Handle the response here
                console.log(response);
                if(response.orderTotal){
                    $('input[name="orderValue"]').val(response.orderTotal);
                    $('input[name="orderPoints"]').val(response.points);
                    $('input[name="order_value"]').val(response.orderTotal);
                    $('input[name="points"]').val(response.points);

                    for (var key in  response.points_per_category) {
                        $('input[name="per_category_points_'+key+'"]').val(response.points_per_category[key]);
                    }

                
                }
            });
        });
    });
}, 2000);
</script>

@endsection
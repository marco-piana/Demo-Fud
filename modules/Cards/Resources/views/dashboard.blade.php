@hasrole('owner')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Customers')}}</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $cards['customers_total']}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-single-02"></i>
                        </div>
                    </div>

                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-users"></i>
                        {{ $cards['customers_this_month']}}</span>
                    <span class="text-nowrap">{{ __('this month') }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Gifts given')}}</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $cards['gifts_given']}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                            <i class="ni ni-trophy"></i>
                        </div>
                    </div>

                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                        {{ $cards['gifts_this_month']}}</span>
                    <span class="text-nowrap">{{ __('this month') }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Points earned')}}</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $cards['points_earned']}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-chart-bar-32"></i>
                        </div>
                    </div>

                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                        {{ $cards['points_this_month']}}</span>
                    <span class="text-nowrap">{{ __('this month') }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Sales value via loyal customers')}}
                        </h5>
                        <span class="h2 font-weight-bold mb-0">{{ $cards['sales_total']}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-money-coins"></i>
                        </div>
                    </div>

                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                        {{ $cards['sales_this_month']}}</span>
                    <span class="text-nowrap">{{ __('this month') }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endhasrole
@hasrole('staff')
<!-- Show Action buttons -->
<a href="{{ route('loyalty.give') }}" type="button" class="btn btn-success btn-lg">{{ __('Give points')}}</a>
<a href="{{ route('loyalty.remove') }}" type="button" class="btn btn-danger btn-lg">{{ __('Redeem points')}}</a>
@endhasrole
@hasrole('client')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Points')}}</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $cards['points']}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-single-02"></i>
                        </div>
                    </div>

                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                        {{ $cards['points_this_month']}}</span>
                    <span class="text-nowrap">{{ __('this month') }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <a href="{{ route('loyaltyawards.peruser') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Gifts received')}}</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $cards['gifts_received']}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                <i class="ni ni-trophy"></i>
                            </div>
                        </div>

                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                            {{ $cards['gifts_this_month']}}</span>
                        <span class="text-nowrap">{{ __('this month') }}</span>
                    </p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <a href="{{ route('loyalty.movments.peruser') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Transactions made')}}</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $cards['transactions_made']}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-chart-bar-32"></i>
                            </div>
                        </div>

                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                            {{ $cards['transactions_this_month']}}</span>
                        <span class="text-nowrap">{{ __('this month') }}</span>
                    </p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <a href="{{ route('loyalty.movments.peruser') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Sales value')}}
                            </h5>
                            <span class="h2 font-weight-bold mb-0">{{ $cards['sales_total']}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>

                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                            {{ $cards['sales_this_month']}}</span>
                        <span class="text-nowrap">{{ __('this month') }}</span>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>
@endhasrole


@hasrole('owner')
@section('dashboard_content')
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ __('Newest customers')}}</h3>
                    </div>
                    <div class="col text-right">
                        <a href="{{ route('loyalty.cards.index') }}"
                            class="btn btn-sm btn-primary">{{ __('See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">

                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('City') }}</th>
                            <th scope="col">{{ __('Points') }}</th>
                            <th scope="col">{{ __('Email') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $cards['customers'] as $customer )
                        <tr>
                            <th scope="row">
                                {{ $customer->client->name }}
                            </th>
                            <td>
                                {{ $customer->client->getConfig('city','') }}
                            </td>
                            <td>
                                {{ $customer->points }}
                            </td>
                            <td>
                                {{ $customer->client->email }}
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ __('Active awards')}}</h3>
                    </div>
                    <div class="col text-right">
                        <a href="{{ route('loyaltyawards.index') }}"
                            class="btn btn-sm btn-primary">{{ __('See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">

                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">{{ __('Award') }}</th>
                            <th scope="col">{{ __('Expires') }}</th>
                            <th scope="col">{{ __('Used') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $cards['awards'] as $award )
                        <tr>
                            <th scope="row">
                                {{ $award->title }}
                            </th>
                            <td>
                                {{ $award->active_to }}
                            </td>
                            <td>
                                {{ $award->used }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@endhasrole


@hasrole('client')
@section('dashboard_content')
<div class="row">

    @foreach ($cards['cards'] as $card)
    <div class="col-xl-3 col-md-6" style="min-width: 400px">
        <a href="{{ $card->vendor->getLinkAttribute() }}">
            <div class="card bg-transparent shadow-xl">
                <div class="overflow-hidden position-relative"
                    style="border-radius: 1rem; position: relative!important;  background-size: cover; background-position: center top;  background-image:url('{{ $card->vendor->getCovermAttribute() }}')">
                    <span style=" position: absolute;
                    background-position: 50%;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-images: linear-gradient(310deg,#212229,#212529); opacity:0.8;

                    background-color: #283783;
                    background-images: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);

                    
                    
                    "></span>
                    <div class="card-body position-relative z-index-1 p-3">
                        <h5 class="text-white mt-2 pb-2">{{ $card->vendor->name }}</h5>
                        <h5 class="text-white mt-4 mb-3 pb-2">{{ $card->card_id }}</h5>
                        <div class="bg-white p-2 mb-2 rounded">
                            <?php  echo $cards['dns1d']->getBarcodeHTML( $card->card_id, 'C39+',0.91,40); ?>
                        </div>
                        
                        </h5>
                        <div class="d-flex">
                            <div class="d-flex">
                                <div class="me-4">
                                    <p class="text-white text-sm opacity-8 mb-0"><b>{{ $card->points }} {{__('points')}}</b></p>
                                    <h6 class="text-white mb-0">{{ $card->client->name }}</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

    </div>
    @endforeach

</div>
@endsection
@endhasrole


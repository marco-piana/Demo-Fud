@extends('general.index', $setup)

@section('customheading')
<div class="row mb-3">
    <div class="col">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">{{ __('Customer')}}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-control-label" for="input-address">{{__('Name')}}</label><br />
                            <span class="" for="input-address">{{ $card->client->name }}</span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label" for="input-address">{{__('Email')}}</label><br />
                            <a href="mailto:{{ $card->client->email }}"><span class="" for="input-address">{{ $card->client->email }}</span></a>
                        </div>
                        <div class="col-md-2">
                            <label class="form-control-label" for="input-address">{{__('Phone')}}</label><br />
                            <a href="tel:{{ $card->client->phone }}"><span class="" for="input-address">{{ $card->client->phone }}</span></a>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label" for="input-address">{{__('Card')}}</label><br />
                            <span class="" for="input-address">{{ $card->card_id }}</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-control-label" for="input-address">{{__('Points')}}</label><br />
                            <span class="badge badge-lg  badge-success">{{ $card->points }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('thead')
    <th>{{ __('Value') }}</th>
    <th>{{ __('Type') }}</th>
    <th>{{ __('Time') }}</th>
    <th>{{ __('By') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td>{{ $item->value }}</td>
            <td>
                @if ($item->type == 1)
                    <span class="badge badge-success">{{ __('Add') }}</span>
                @else
                    <span class="badge badge-danger">{{ __('Subtract') }}</span>
                @endif
            </td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->staff?$item->staff->name:"" }}</td>
        </tr> 
    @endforeach
@endsection
@extends('general.index', $setup)
@section('contenttop')

    
@endsection
@section('thead')
    <th>{{ __('Code') }}</th>
    <th>{{ __('Customer') }}</th>
    <th>{{ __('Date') }}</th>
    <th>{{ __('Table') }}</th>
    <th>{{ __('Status') }}</th>
    <th>{{ __('crud.actions') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td><a href="{{ route('tablereservations.edit',['reservation'=>$item->id]) }}" >#{{ $item->reservation_code }}</a></td>
            <td>
                <div class="media align-items-center">
                    <a href="#" class="avatar rounded-circle mr-3">
                        <img alt="Avatar" src="{{ $item->customer->gravatar }}">
                    </a>
                    </a>
                    <div class="media-body">
                        <span class="name mb-0 text-sm">
                            {{ $item->customer->name }} 
                            <br />
                            <a href="tel:{{ $item->customer->phone }}">{{ $item->customer->phone }}</a>
                        </span>
                    </div>
                </div>
            </td>
            <td>
                {{ $item->relative_time }}
                <br />
                {{ $item->expected_occupancy }} {{__('min')}}
            </td>

            @if ($item->table)
                <td>
                    {{ $item->table->full_name }}
                    <br />
                    {{ $item->number_of_guests }} {{ __('guests') }}
                </td>
            @else
                <td>{{ __('No table') }}</td>
            @endif
            <td>
               @include('tablereservations::reservations.status',['status'=>$item->status]) 
            </td>
          
            <td>
               
                <!-- EDIT -->
                <a href="{{ route('tablereservations.edit',['reservation'=>$item->id]) }}" class="btn btn-primary btn-sm">
                    <i class="ni ni-ruler-pencil"></i>
                </a>

                <!-- DELETE -->
                <a href="{{ route('contacts.delete',['contact'=>$item->id]) }}" class="btn btn-danger btn-sm">
                    <i class="ni ni ni-fat-remove"></i>
                </a>
            </td>
        </tr> 
    @endforeach
@endsection
@section('js')
    @include('contacts::contacts.scripts')
@endsection
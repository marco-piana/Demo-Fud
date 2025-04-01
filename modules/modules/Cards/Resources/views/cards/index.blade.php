@extends('general.index', $setup)
@section('thead')
    <th>{{ __('Name') }}</th>
    <th>{{ __('Card') }}</th>
    <th>{{ __('Points') }}</th>
    <th>{{ __('Movements') }}</th>
    <th>{{ __('crud.actions') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td><a href="{{ route('loyalty.movments.index',['card'=>$item->id]) }}"> {{ $item->client->name }}</a></td>
            <td><a href="{{ route('loyalty.movments.index',['card'=>$item->id]) }}">{{ $item->card_id }}</a></td>
            <td>{{ $item->points }}</td>
            <td><a alt="{{ __('Movements') }}" href="{{ route('loyalty.movments.index',['card'=>$item->id]) }}" class="">{{ $item->movments->count() }}</a></td>
            <td>
                <!-- EDIT -->
                <a href="{{ route('loyalty.cards.edit',['card'=>$item->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-pencil-alt"></i>
                </a>

                <!-- MOVMENTS -->
                <a alt="{{ __('Movements') }}" href="{{ route('loyalty.movments.index',['card'=>$item->id]) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-list"></i>

                <!-- Add points -->
                <a alt="{{ __('Add points') }}" href="{{ route('loyalty.give',['card'=>$item->id]) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
                </a>
            </td>
        </tr> 
    @endforeach
@endsection
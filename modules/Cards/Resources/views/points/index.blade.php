@extends('general.index', $setup)
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->percent }}%</td>
            <td>{{ $item->staticpoints }} {{__('points')}}</td>
            <td>{{ $item->threshold }}</td>
            @include('partials.tableactions',$setup)
        </tr> 
    @endforeach
@endsection
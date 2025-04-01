@extends('general.index', $setup)


@section('thead')
    <th>{{ __('Points') }}</th>
    <th>{{ __('Type') }}</th>
    <th>{{ __('Time') }}</th>
    <th>{{ __('Order') }}</th>
    <th>{{ __('Order value') }}</th>
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
            <td>@if ($item->type == 1)#{{ $item->order_id }}@endif</td>
            <td>@if ($item->type == 1){{ $item->order_value }}@endif</td>
            <td>{{ $item->vendor->name }}</td>
        </tr> 
    @endforeach
@endsection
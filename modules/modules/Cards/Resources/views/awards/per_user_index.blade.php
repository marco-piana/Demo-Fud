@extends('general.index', $setup)

@section('thead')
    <th>{{ __('Status') }}</th>
    <th>{{ __('Name') }}</th>
    <th>{{ __('Vendor') }}</th>
    <th>{{ __('Code') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td>
                @if ( $item->used_count >= $item->limit_to_num_uses)
                    <span class="badge badge-danger">Used</span>
               @else
                    <span class="badge badge-success">Active</span>
                @endif
            </td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->vendor->name }}</td>
            <td>{{ $item->code }}</td>
            
            
            
        </tr>
    @endforeach
@endsection

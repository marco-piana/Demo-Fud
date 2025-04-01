@if ($status == 'pending')
    <span class="badge badge-dot mr-4">
        <i class="bg-warning text-white"></i> {{ __('Pending') }}
    </span>
@elseif ($status == 'confirmed')
    <span class="badge badge-dot mr-4">
        <i class="bg-success text-white"></i> {{ __('Confirmed') }}
    </span>
@elseif ($status == 'cancelled')
    <span class="badge badge-dot mr-4">
        <i class="bg-danger text-white"></i> {{ __('Cancelled') }}
    </span>
@elseif ($status == 'completed')
    <span class="badge badge-dot mr-4">
        <i class="bg-info text-white"></i> {{ __('Completed') }}
    </span>
@elseif ($status == 'seated')
    <span class="badge badge-dot mr-4">
        <i class="bg-primary text-white"></i> {{ __('Seated') }}
    </span>
@elseif ($status == 'soon')
    <span class="badge badge-dot mr-4">
        <i class="bg-warning text-white"></i> {{ __('Soon') }}
    </span>
@elseif ($status == 'late')
    <span class="badge badge-dot mr-4">
        <i class="bg-dark text-white"></i> {{ __('Late') }}
    </span>
@elseif ($status == 'no-show')
    <span class="badge badge-dot mr-4">
        <i class="bg-warning text-white"></i> {{ __('No Show') }}
    </span>
@else
    <span class="badge badge-dot mr-4">
        <i class="bg-warning text-white"></i> {{ __($status) }}
    </span>
@endif 
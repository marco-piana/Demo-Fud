<!-- STRIPE -->
<form action="/charge" method="post" id="stripe-payment-form" class="mb-3" style="display: {{ config('settings.default_payment')=="stripe"?"block":"none"}};">
    @csrf  
    <div style="width: 100%;" class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        <input name="name" id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __( 'Name on card' ) }}" value="{{auth()->user()?auth()->user()->name:""}}" required>
        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form">
        <div style="width: 100%;" #stripecardelement  id="card-element" class="form-control">
        <!-- A Stripe Element will be inserted here. -->
        </div>
        <!-- Used to display form errors. -->
        <div class="" id="card-errors" role="alert">

        </div>
    </div>
    <input type="submit" style="display: none" id="stripeSend">
</form>


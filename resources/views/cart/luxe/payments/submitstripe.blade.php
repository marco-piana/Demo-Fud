<!-- STRIPE -->
@if (config('settings.stripe_key')&&config('settings.enable_stripe'))
  <div class="text-center" style="display: none" id="totalSubmitStripe">
    <i id="indicatorStripe" style="display: none" class="fa fa-spinner fa-spin"></i>
      <label
        v-if="totalPrice"
        for="stripeSend"
        tabindex="0"
        class="button full-button d-flex align-items-center justify-content-center uppercase paymentbutton">
        {{ __('Place an order') }}
      </label>
  </div>
@endif

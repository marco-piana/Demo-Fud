@if(!config('settings.hide_cod'))
    <div class="text-center" id="totalSubmitCOD"  style="display: {{ config('settings.default_payment')=="cod"&&!config('settings.hide_cod')?"block":"none"}};" >
        <button v-if="totalPrice" type="button" class='button full-button d-flex align-items-center justify-content-center uppercase' onclick="document.getElementById('order-form').submit();">{{ __('Place order') }}</button>
    </div>
@endif

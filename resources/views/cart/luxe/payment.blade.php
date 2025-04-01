<div class="card">
    <div class="card-header text-center">
        <h4 class="uppercase">{{ __('Order Summary') }}</h4>
    </div>
    <div class="card-body">
        @include('cart.luxe.items')
        <hr class="dashed">

        <!-- Price overview -->
        <div id="totalPrices" v-cloak>
            <div class="d-flex justify-content-center align-items-center" v-if="totalPrice==0">{{ __('Cart is empty') }}!</div>
            <ul class="clearfix">
                <li v-if="totalPrice">{{ __('Subtotal') }}:<span class="text-dark">@{{ totalPriceFormat }}</span></li>
                @if(config('app.isft')||config('settings.is_whatsapp_ordering_mode')|| in_array("poscloud", config('global.modules',[])) || in_array("deliveryqr", config('global.modules',[])) )
                <li v-if="totalPrice&&deliveryPrice>0">{{ __('Delivery') }}:<span>@{{ deliveryPriceFormated }}</span></li>
                @endif
                <li v-if="deduct">{{ __('Coupon discount') }}:<span v-if="deduct" class="ammount">@{{ deductFormat }}</span></li>
                
                <li v-if="tip">{{ __('Applied Tip') }}:<span class="text-dark">@{{ tipFormat }}</span></li>
                
                <li v-if="totalPrice" class="total text-dark">{{ __('Total') }}:<span class="text-lg text-dark">@{{ withDeliveryFormat }}</span></li>
                <input v-if="totalPrice" type="hidden" id="tootalPricewithDeliveryRaw" :value="withDelivery" />
            </ul>
        </div>
        <!-- End price overview -->
        <div class="cart-modules ">
            @if(in_array("coupons", config('global.modules',[])))
                <!-- Coupons -->
                <div class="coupons-luxe">
                    <a  data-toggle="modal" data-target="#applyCoupon" href="javascript:;" class="full-button rounded-sm d-flex justify-content-center align-items-center p-3 mb-3 border text-center text-muted text-sm"><svg width="18" viewBox="0 0 25.99 25.99" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="3" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M14.2 21.69l9.88-9.89v0c.06-.06.12-.13.17-.2 1.2-2 .63-7.39.37-9.38v0c-.07-.45-.42-.8-.86-.85 -2-.27-7.36-.84-9.37.37l0-.001c-.08.04-.15.1-.21.16L4.3 11.78"/><path d="M5.35 10.74l-3.49 3.49 -.001-.001c-1.15 1.16-1.15 3.04 0 4.21l5.68 5.66H7.53c1.16 1.15 3.05 1.15 4.22 0l3.49-3.49"/></g><path stroke="currentColor" stroke-width="3" d="M20.02 5.49a.5.5 0 1 0 0 1 .5.5 0 1 0 0-1Z"/></svg>&nbsp;{{ __('Apply Coupon') }}</a>
                </div>
                <!-- End coupons -->
            @endif
            
            @if(in_array("tips", config('global.modules',[])))
                <!-- Tip -->
                <div class="tips-luxe">
                    <a  data-toggle="modal" data-target="#addTip" href="javascript:;" class="full-button rounded-sm d-flex justify-content-center align-items-center p-3 mb-3 border text-center text-muted text-sm"><svg width="18" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 21h9.62c1.16 0 2.276-.51 3.03-1.4l5.102-5.952c.21-.26.29-.6.2-.92 -.09-.33-.34-.58-.65-.69l-1.968-.66c-.96-.32-2.05-.13-2.83.5l-3.19 2.54 -.62-1.24c-.69-1.37-2.06-2.21-3.58-2.21H3.96c-1.11 0-2 .89-2 2v6c0 1.1.89 2 2 2Zm0-8h5.14c.76 0 1.44.42 1.78 1.1l.44.89H9.97h-2 -1v2h1 2 3s0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0c.15-.01.3-.05.44-.11 0 0 0 0 0-.01s0-.01 0-.01 0 0 0 0h0s0 0 0 0 0 0 0-.01c0 0 0 0 0 0h0s0 0 0 0 0 0 0 0 0 0 0-.01c0 0 0-.01 0-.01 .01 0 0-.01 0-.01s0 0 0 0 0 0 0-.01c0 0 0-.01 0-.01s0 0 0-.01c0 0 0-.01 0-.01v0s0-.01 0-.01 0 0 0-.01c0 0 0-.01 0-.01s0-.01 0-.01c0-.01 0 0 0-.01s0-.01 0-.01v0c0-.01 0-.01 0-.01s0 0 0-.01c0 0 0 0 0 0s0-.01 0-.01 0 0 0 0 0 0 0-.01v0s0 0 0-.01 0-.01 0-.01c0-.01 0-.01 0-.01 .03-.03.07-.05.11-.08l4.14-3.317c.26-.21.62-.28.94-.17l.55.18 -4.14 4.82c-.39.43-.94.68-1.52.68H3.87v-6ZM16 2v0c-.01 0-.02 0-.02 0 -.17 0-1.01.03-1.99.7 -.96-.65-1.78-.7-1.968-.71 -.01-.001-.03-.01-.03-.01 -.01 0-.01 0-.01 0v0c-.01 0-.01 0-.01 0v0c-.81 0-1.56.31-2.12.87 -.57.56-.88 1.32-.88 2.122 0 .8.31 1.55.86 2.104l3.41 3.58c.19.19.45.31.72.31 .27 0 .53-.12.72-.32l3.39-3.57c.56-.57.87-1.32.87-2.13 0-.81-.32-1.56-.88-2.121 -.57-.57-1.32-.879-2.12-.879v0s-.01 0-.01 0Zm1 3c0 .26-.11.51-.32.72l-2.689 2.82 -2.71-2.843c-.19-.19-.3-.44-.3-.71 0-.27.1-.52.29-.71 .18-.19.43-.3.68-.3 .02 0 .5.03 1.06.48 .08.06.16.13.24.22l.7.7 .7-.71c.08-.09.16-.16.24-.23 .52-.43.97-.48 1.05-.484 .26 0 .51.1.7.29 .18.18.29.44.29.7Z"/></svg>&nbsp;{{ __('Add Tip')}}</a>
                </div>
            @endif
            <!-- End tip -->
        </div>
        

        <div class="terms-checkbox rounded-sm d-flex justify-content-center align-items-center p-3 mb-3 border text-center text-muted text-sm">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="privacypolicy" checked type="checkbox">
                <label class="custom-control-label text-sm" for="privacypolicy">
                    &nbsp;&nbsp;{{__('I agree to the')}}
                    <a href="{{config('settings.link_to_ts')}}" target="_blank" style="text-decoration: underline;">{{__('Terms of Service')}}</a>
                </label>
            </div>
        </div>
        
        

        <!-- Payment Actions -->
        @if(!config('settings.social_mode'))

            <!-- COD -->
            @include('cart.luxe.payments.cod')

            <!-- Extra Payments ( Via module ) -->
            @foreach ($extraPayments as $extraPayment)
                @include($extraPayment.'::button')
            @endforeach
            </form>
            <!--  [[[[[[[[[Closing Order Form !]]]]]]]]] -->
           

            <!-- Stripe -->
            @include('cart.luxe.payments.stripe')
            @include('cart.luxe.payments.submitstripe')

            

        @elseif(config('settings.is_whatsapp_ordering_mode'))
            @include('cart.luxe.payments.whatsapp')
        @elseif(config('settings.is_facebook_ordering_mode'))
            @include('cart.luxe.payments.facebook')
        @endif
        <!-- END Payment Actions -->
    </div>


@extends('layouts.front-luxe', ['class' => ''])
@section('content')
<section class="relative hero-background">
  <picture data-background=true >
      <div class="opacity-mask"></div>
      <source  srcset="{{ $restorant->coverm }}" media="(min-width: 569px)" />
      <img src='{{ $restorant->coverm }}' />        
  </picture>
  <div class="d-flex align-items-center justify-content-center hero-title">
  <div class="hero-container text-center">
  <h5 class="mb-1">{{ $restorant->name }}</h5>
  <h1 class="mb-4">{{ __('Checkout') }}</h1>
  <div class="inline-links justify-content-center align-items-center">
    <!-- @include('cart/luxe/herobuttons') -->
  </div>
  </div>
  </div>
</section>
<section class="section section-place-content py-5">
  <div class="container">
  @include('notify::components.notify')
      <div class="row justify-content-center">
        <!-- Left part -->
          <div class="col-md-7 mb-4">
            <div class="card card-checkout">
              <form id="order-form" role="form" method="post" action="{{route('order.store')}}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @if(!config('settings.social_mode'))
                  @if (config('app.isft')&&count($timeSlots)>0)
                    <!-- FOOD TIGER -->
                    @include('cart.luxe.product.foodtiger')
                  @elseif(config('app.isag')&&count($timeSlots)>0)
                    <!-- Agris Mode -->
                    @include('cart.luxe.product.agris')
                  @elseif(config('app.isqrsaas')&&count($timeSlots)>0)
                    <!-- QR Saas Mode -->
                    @include('cart.luxe.product.qrsaas')
                  @endif
                  @if(in_array("coupons", config('global.modules',[])))
                    <!-- Coupon Modal -->
                    @include('cart.luxe.coupons')
                  @endif
                  @if(in_array("tips", config('global.modules',[])))
                    <!-- Tip Modal -->
                    @include('cart.luxe.tips')
                  @endif        
                  <!-- Was removed the closing form -->
                  <hr class="dashed">
                  @if (count($timeSlots)>0)
                    <!-- Payment Methods-->
                    <div class="row">
                      <div class="col-12 col-md-3">
                        <h5 class="text-muted">3.</h5>
                        <h4 class="uppercase">{{ __('Payment Method') }}</h4>
                      </div>
                      <div class="col-12 col-md-9">
                        <div class="card-body payment-select">
                          <!-- Errors on Stripe -->
                          @if (session('error'))
                              <div role="alert" class="alert alert-danger">{{ session('error') }}</div>
                          @endif

                          @if(!config('settings.is_whatsapp_ordering_mode'))
                            <!-- COD -->
                            @if (!config('settings.hide_cod'))
                              <div class="custom-control custom-radio mb-3">
                                <input name="paymentType" class="custom-control-input" id="cashOnDelivery" type="radio" value="cod" {{ config('settings.default_payment')=="cod"?"checked":""}}>
                                <label class="custom-control-label d-flex justify-content-start align-items-center" for="cashOnDelivery">
                                    <div class="delTime"><svg width="17" viewBox="0 0 30 29.92" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="3" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M17.59 28.86L1.67 23.27h0c-.4-.14-.67-.52-.67-.94V3.58h0c-.04-.56.39-1.03.94-1.06 .13-.01.26.01.38.05l15.67 5.55c.55 0 1 .67 1 1.49V27.5v0c0 .3-.07.61-.2.89v0c-.24.42-.75.62-1.21.46Z"/><path d="M1 21V2v0c0-.56.44-1 1-1h25l-.001-.001c1.19.1 2.08 1.15 2 2.35v15.3 0c.08 1.19-.81 2.24-2 2.35h-8"/><path d="M26 6L12 6"/><path d="M26 11l-7 0"/><path d="M13 15a2 2 0 1 0 0 4 2 2 0 1 0 0-4Z"/></g></svg>&nbsp;&nbsp;{{ config('app.isqrsaas')?__('Cash / Card Terminal'): __('Cash on delivery') }}</div>
                                    <div class="picTime"><svg width="17" viewBox="0 0 28.42 28" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="3" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M24.18 17.88c1.6.67 3.24 1.67 3.24 3.18v0c-.15 1.64-1.6 2.85-3.24 2.72v0c-1.65.13-3.1-1.08-3.24-2.72"/><path d="M24.18 17.88c-1.6-.68-3.24-1.68-3.24-3.19v0c.16-1.64 1.6-2.83 3.24-2.69v0c1.64-.14 3.09 1.07 3.24 2.72"/><path d="M24.18 9.37l0 2.58"/><path d="M24.18 23.8l0 2.58"/><path d="M3 22h14v5H3Z"/><path d="M4 17h14v5H4Z"/><path d="M1 12h14v5H1Z"/><path d="M3 7h14v5H3Z"/><path d="M20 1l0 3"/><path d="M21.5 2.5l-3 0"/></g></svg>&nbsp;&nbsp;{{ __('Cash on pickup') }}</div>
                                </label>
                                <span class="checkmark"></span>
                              </div>
                            @endif

                            @if($enablePayments)
                              <!-- STRIPE CART -->
                              @if (config('settings.stripe_key')&&config('settings.enable_stripe'))
                                <div class="custom-control custom-radio mb-3">
                                  <input name="paymentType" class="custom-control-input" id="paymentStripe" type="radio" value="stripe" {{ config('settings.default_payment')=="stripe"?"checked":""}}>
                                  <label class="custom-control-label d-flex justify-content-start align-items-center" for="paymentStripe"><svg width="17" viewBox="0 0 30 22" xmlns="http://www.w3.org/2000/svg"><g stroke-width="3" fill="none" stroke="currentColor"><rect width="28" height="20" x="1" y="1" rx="3"/><g stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M9 15l-4 0"/><path d="M5 5h4v4H5Z"/><path d="M22.5 12a2.5 2.5 0 1 0 0 5 2.5 2.5 0 1 0 0-5Z"/><path d="M20.5 16v0c-.83 1.11-2.41 1.34-3.52.51 -1.12-.83-1.35-2.41-.52-3.52 .82-1.12 2.4-1.35 3.51-.52 .19.14.36.31.51.51"/></g></g></svg>&nbsp;&nbsp;{{ __('Pay with card') }}</label>
                                  <span class="checkmark"></span>
                                </div>
                              @endif
                              <!-- Extra Payments ( Via module ) -->
                              @foreach ($extraPayments as $extraPayment)
                                @include($extraPayment.'::selector')
                              @endforeach
                              <!-- End Extra Payments -->
                            @endif
                          @endif
                          
                        </div>
                      </div>
                    </div>
                  @endif
              @else
                <!-- Social MODE -->
                @if(count($timeSlots)>0)
                  @include('cart.luxe.product.social')
                @endif
              @endif
          </div><!-- end card -->
        </div>
        <!-- Right Part -->
        <div class="col-md-5">
          @if (count($timeSlots)>0)
              <!-- Payment -->
              @include('cart.luxe.payment')
          @else
              <!-- Closed restaurant -->
              @include('cart.luxe.closed')
          @endif
        </div>
          <div class="my-3 text-center">
            <h6 class="text-center text-muted"><small>{{ __('Powered by') }} <a href="/" target="_blank" rel="noopener noreferrer">{{ config('global.site_name') }}</a> – &copy; {{ date('Y') }}</small></h6>
          </div>
      </div><!-- end row -->
    </div><!-- end container -->
  <!-- Testing modals -->
  @include('cart.luxe.modals')
  </section>
@endsection
@section('js')

  <script async defer src= "https://maps.googleapis.com/maps/api/js?key=<?php echo config('settings.google_maps_api_key'); ?>&callback=initAddressMap"></script>
  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    "use strict";
    var RESTORANT = <?php echo json_encode($restorant) ?>;
    var STRIPE_KEY="{{ config('settings.stripe_key') }}";
    var ENABLE_STRIPE="{{ config('settings.enable_stripe') }}";
    var SYSTEM_IS_QR="{{ config('app.isqrexact') }}";
    var SYSTEM_IS_WP="{{ config('app.iswp') }}";
    var initialOrderType = 'delivery';
    if(RESTORANT.can_deliver == 1 && RESTORANT.can_pickup == 0){
        initialOrderType = 'delivery';
    }else if(RESTORANT.can_deliver == 0 && RESTORANT.can_pickup == 1){
        initialOrderType = 'pickup';
    }
  </script>
  <script>
  var fieldWidth = $("#localorder_phone").width();
  console.log('width:' + fieldWidth + 'px');
  </script>
  @if (config('app.isft'))
  <script>
    $(document).ready(function() {
    
      $('#new_address_checkout').select2({
          dropdownParent: $("#modal-order-new-address"),
          placeholder: " {{ __('Start typing your address') }} ",
          ajax: {
              url: '/new/address/autocomplete',
              dataType: 'json',
              //delay: 200,
              data: function(params) {
                  return {
                      term: params.term,
                      page: params.page
                  };
              },
              processResults: function(data, params) {
                  params.page = params.page || 1;

                  return {
                      results: data.results,
                      pagination: {
                          more: (params.page * 10) < data.total
                      }
                  };
              },
              minimumInputLength: 3,
          }
      });
    });
  </script>
  @endif
  
  <script src="{{ asset('custom') }}/js/checkout.js"></script>
@endsection



<!-- Add Coupon -->
<div class="modal fade bd-example-moda" id="applyCoupon" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('Apply Coupon') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <input  id="coupon_code" name="coupon_code" type="text" class="form-control form-control-alternative mb-4" placeholder="{{ __('Discount coupon')}}">
                <div class="row no-gutters">
                    <div class="col"><button type="button" class="btn mb-0 bg-transparent rounded-sm d-flex justify-content-center align-items-center border w-100 bg-transparent text-center text-muted text-sm " data-dismiss="modal" aria-label="Close">{{ __('Cancel')}}</button></div>
                    <div class="col"><button id="promo_code_btn" type="button" class="btn w-100 d-flex justify-content-center align-items-center rounded-sm btn-outline-primary text-sm">{{ __('Apply') }}</button></div>
                </div>
                <span><i id="promo_code_succ" class="ni ni-check-bold text-success"></i></span>
                <span><i id="promo_code_war" class="ni ni-fat-remove text-danger"></i></span>
            </div>
        </div>
    </div>
</div>

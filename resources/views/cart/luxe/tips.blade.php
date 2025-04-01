<!-- Add Tip Modal -->
<div class="modal fade bd-example-moda" id="addTip" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered " role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="mb-0">{{ __('Add Tip') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div  class="row mx-0 align-items-center">
                    <div class="col-md-7 px-0 pr-1 mb-4">
                        <input  id="tipapplied" name="tipapplied" type="hidden" value="0">
                        <input  id="tip" name="tip" type="number" min="0" value="0" class="form-control form-control-alternative" placeholder="{{ __('Tip Amount')}}">
                    </div>
                    
                    <div class="col-md-5 px-0 pl-1">
                        <button id="tip_btn" type="button" class="btn w-100 d-flex justify-content-center align-items-center rounded-sm btn-outline-primary text-sm">{{ __('Add tip') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

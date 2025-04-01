<!-- Movments -->
<div class="card bg-secondary shadow mt-4">
    <div class="card-header bg-white border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __('Movements') }}</h3>
            </div>
        </div>
    </div>

    <!-- The table data -->
    <div class="card-body">
        <div class="pl-lg-0">
            @if(count($movements))
                <div class="table-responsive">
                    <table class="table align-items-center">
                        @include('cards::points.movements_table')
                    </table>
                </div>
            @endif
            <div class=" py-4">
                @if(count($movements))
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $movements->appends(Request::all())->links() }}
                </nav>
                @else
                    <h4>{{ __('No items') }} ...</h4>
                @endif
            </div>
        </div>
</div>
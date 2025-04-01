{{-- Brij Negi Update --}}
@extends('layouts.app', ['title' => __('Restaurant Menu Management')])
@section('admin_title')
    {{ __('Menu') }}
@endsection
@section('content')
    @include('items.partials.modals', ['restorant_id' => $restorant_id])

    <div class="header bg-gradient-primary pb-7 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <!--<div class="col-lg-6 col-7">
                                                                                                                        </div>-->
                    <div class="col-lg-12 col-12 text-right">
                        @if (isset($hasMenuPDf) && $hasMenuPDf)
                            <a target="_blank" href="{{ route('menupdf.download') }}" class="btn btn-sm btn-danger"><i
                                    class="fas fa-file-pdf"></i> {{ __('PDF Menu') }}</a>
                        @endif
                        <button class="btn btn-icon btn-1 btn-sm btn-info" type="button" data-toggle="modal"
                            data-target="#modal-items-category" data-toggle="tooltip" data-placement="top"
                            title="{{ __('Add new category') }}">
                            <span class="btn-inner--icon"><i class="fa fa-plus"></i> {{ __('Add new category') }}</span>
                        </button>
                        @if ($canAdd)
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#modal-import-items" onClick=(setRestaurantId({{ $restorant_id }}))>
                                <span class="btn-inner--icon"><i class="fa fa-file-excel"></i>
                                    {{ __('Import from CSV') }}</span>
                            </button>
                        @endif
                        @if (config('settings.enable_miltilanguage_menus'))
                            @include('items.partials.languages')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Restaurant Menu Management') }} @if (config('settings.enable_miltilanguage_menus'))
                                                ({{ $currentLanguage }})
                                            @endif
                                        </h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <button class="btn btn-sm btn-success full-button">Full View</button>
                                        <button class="btn btn-sm btn-success compact-button">Compact View</button>
                                    </div>
                                    <div class="col-auto">
                                        <!--<button class="btn btn-icon btn-1 btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal-items-category" data-toggle="tooltip" data-placement="top" title="{{ __('Add new category') }}">
                                                                                                                                                    <span class="btn-inner--icon"><i class="fa fa-plus"></i> {{ __('Add new category') }}</span>
                                                                                                                                                </button>
                                                                                                                                                @if ($canAdd)
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-import-items" onClick=(setRestaurantId({{ $restorant_id }}))>
                                                                                                                                                        <span class="btn-inner--icon"><i class="fa fa-file-excel"></i> {{ __('Import from CSV') }}</span>
                                                                                                                                                    </button>
    @endif
                                                                                                                                                @if (config('settings.enable_miltilanguage_menus'))
    @include('items.partials.languages')
    @endif-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="col-12">
                        @include('partials.flash')
                    </div>
                    <div class="card-body">
                        @if (count($categories) == 0)
                            <div class="col-lg-3">
                                <a data-toggle="modal" data-target="#modal-items-category" data-toggle="tooltip"
                                    data-placement="top" title="{{ __('Add new category') }}">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ asset('images') }}/default/add_new_item.jpg"
                                            alt="...">
                                        <div class="card-body">
                                            <h3 class="card-title text-primary text-uppercase">
                                                {{ __('Add first category') }}</h3>
                                        </div>
                                    </div>
                                </a>
                                <br />
                            </div>
                        @endif

                        <div class="items-container">
                            @foreach ($categories as $index => $category)
                                <div class="alert alert-default category-container">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h1 font-weight-bold mb-0 text-white">{{ $category->name }}
                                                @if ($category->active == 0)
                                                    <span class="badge badge-neutral ml-2">{{ __('Paused') }}</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="row">
                                                <script>
                                                    function setSelectedCategoryId(id) {
                                                        $('#category_id').val(id);
                                                    }

                                                    function setRestaurantId(id) {
                                                        $('#res_id').val(id);
                                                    }
                                                </script>
                                                @if ($canAdd)
                                                    <button class="btn btn-icon btn-1 btn-sm btn-primary" type="button"
                                                        data-toggle="modal" data-target="#modal-new-item"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('Add item in') }} {{ $category->name }}"
                                                        onClick=(setSelectedCategoryId({{ $category->id }}))>
                                                        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                                                    </button>
                                                @else
                                                    <a href="{{ route('plans.current') }}"
                                                        class="btn btn-icon btn-1 btn-sm btn-warning" type="button">
                                                        <span class="btn-inner--icon"><i class="fa fa-plus"></i>
                                                            {{ __('Menu size limit reaced') }}</span>
                                                    </a>
                                                @endif
                                                <button class="btn btn-icon btn-1 btn-sm btn-warning" type="button"
                                                    id="edit" data-toggle="modal" data-target="#modal-edit-category"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('Edit category') }} {{ $category->name }}"
                                                    data-id="<?= $category->id ?>" data-name="<?= $category->name ?>">
                                                    <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                                </button>


                                                <!-- If category is active, show the pause button -->
                                                @if ($category->active == 1)
                                                    <a href="{{ route('categories.pause', $category->id) }}"
                                                        class="btn btn-icon btn-1 btn-sm btn-warning"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('Pause category') }} {{ $category->name }}">
                                                        <span class="btn-inner--icon"><i class="fa fa-pause"></i></span>
                                                    </a>
                                                @endif

                                                <!-- If category is paused, show the resume button -->
                                                @if ($category->active == 0)
                                                    <a href="{{ route('categories.resume', $category->id) }}"
                                                        class="btn btn-icon btn-1 btn-sm btn-success"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('Resume category') }} {{ $category->name }}">
                                                        <span class="btn-inner--icon"><i class="fa fa-play"></i></span>
                                                    </a>
                                                @endif



                                                <form action="{{ route('categories.destroy', $category) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-icon btn-1 btn-sm btn-danger" type="button"
                                                        onclick="confirm('{{ __('Are you sure you want to delete this category?') }}') ? this.parentElement.submit() : ''"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('Delete') }} {{ $category->name }}">
                                                        <span class="btn-inner--icon"><i class="fa fa-trash"></i></span>
                                                    </button>
                                                </form>

                                                @if (count($categories) > 1)
                                                    <div style="margin-left: 10px; margin-right: 10px">|</div>
                                                @endif

                                                <!-- UP -->
                                                @if ($index != 0)
                                                    <a href="{{ route('items.reorder', ['up' => $category->id]) }}"
                                                        class="btn btn-icon btn-1 btn-sm btn-success">
                                                        <span class="btn-inner--icon"><i
                                                                class="fas fa-arrow-up"></i></span>
                                                    </a>
                                                @endif


                                                <!-- DOWN -->
                                                @if ($index + 1 != count($categories))
                                                    <a href="{{ route('items.reorder', ['up' => $categories[$index + 1]->id]) }}"
                                                        class="btn btn-icon btn-1 btn-sm btn-success">
                                                        <span class="btn-inner--icon"><i
                                                                class="fas fa-arrow-down"></i></span>
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Brij Negi Update --}}
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="row row-grid category-items">
                                            @foreach ($category->items as $item)
                                                <div class="col-lg-3 item" data-item-id="{{ $item->id }}"
                                                    data-item-name="{{ $item->name }}"
                                                    data-item-description="{{ $item->description }}"
                                                    data-item-price="@php echo money($item->price, config('settings.cashier_currency'), config('settings.do_convertion')); @endphp"
                                                    data-item-availability="{{ $item->available }}"
                                                    data-item-availabilityinlang="{{ $item->is_available_for_lang == 1 ? 1 : ($item->is_available_for_lang == 0 ? 0 : 1) }}"
                                                    data-item-logom="{{ $item->logom }}">
                                                    <a href="{{ route('items.edit', $item) }}">
                                                        <div class="card">
                                                            <img class="card-img-top" src="{{ $item->logom }}"
                                                                alt="...">
                                                            <div class="card-body">
                                                                <h3 class="card-title text-primary text-uppercase">
                                                                    {{ $item->name }}</h3>
                                                                <p class="card-text description mt-3">
                                                                    {{ $item->description }}</p>
                                                                <span class="badge badge-primary badge-pill">
                                                                    @money($item->price, config('settings.cashier_currency'), config('settings.do_convertion'))
                                                                </span>
                                                                <p class="mt-3 mb-0 text-sm">
                                                                    @if ($item->available == 1)
                                                                        <span
                                                                            class="text-success">{{ __('AVAILABLE') }}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-danger">{{ __('UNAVAILABLE') }}</span>
                                                                    @endif

                                                                    ||

                                                                    @if ($item->is_available_for_lang == 1)
                                                                        <span
                                                                            class="text-success">{{ __('Item active') }}</span>
                                                                    @elseif ($item->is_available_for_lang == 0)
                                                                        <span
                                                                            class="text-danger">{{ __('Item inactive') }}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-success">{{ __('Item active') }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <br />
                                                    </a>
                                                </div>
                                            @endforeach
                                            @if ($canAdd)
                                                <div class="col-lg-3 add-item">
                                                    <a data-toggle="modal" data-target="#modal-new-item"
                                                        data-toggle="tooltip" data-placement="top"
                                                        href="javascript:void(0);"
                                                        onclick=(setSelectedCategoryId({{ $category->id }}))>
                                                        <div class="card">
                                                            <img class="card-img-top"
                                                                src="{{ asset('images') }}/default/add_new_item.jpg"
                                                                alt="...">
                                                            <div class="card-body">
                                                                <h3 class="card-title text-primary text-uppercase">
                                                                    {{ __('Add item') }}</h3>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <br />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $("[data-target='#modal-edit-category']").on('click', function() {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');



            $('#cat_name').val(name);
            $("#form-edit-category").attr("action", "/categories/" + id);
        })
    </script>
    {{-- Brij Negi Update --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        const compactButtons = document.querySelectorAll('.compact-button');
        const fullButtons = document.querySelectorAll('.full-button');

        compactButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const itemsContainer = document.querySelectorAll('.items-container')[index];
                const items = itemsContainer.querySelectorAll('.item');
                //selectButton(compactButtons, button, fullButtons);

                $('.items-container .add-item').hide();
                items.forEach(item => {
                    const id = item.dataset.itemId;
                    const name = item.dataset.itemName;
                    const description = item.dataset.itemDescription;
                    const price = item.dataset.itemPrice;
                    const logom = item.dataset.itemLogom;
                    const available = item.dataset.itemAvailability;
                    const availableinlang = item.dataset.itemAvailabilityinlang;
                    // console.log(availableinlang);
                    const availabilityInLangText = availableinlang == 1 ?
                        `<small class="text-success">Item active</small>` :
                        `<small class="text-danger mr-1">Item inactive</small>`;
                    const availabilityText = available == 1 ?
                        `<small class="text-success">AVAILABLE</small>` :
                        `<small class="text-danger">UNAVAILABLE</small>`;
                    item.innerHTML = `
                            <a href="/items/${id}/edit">
                                <div class="card">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <p class="card-text description text-truncate"><span class="card-title font-weight-bold text-primary text-uppercase">${name}</span> - ${description}</p>
                                        
                                        <div class="d-flex align-items-center mt-1">
                                            <span class="badge badge-primary badge-pill mr-2">${price}</span>
                                            ${availabilityText} || ${availabilityInLangText}
                                        </div>
                                    </div>
                                </div>
                                <br />
                            </a>
                        `;
                    item.className = 'col-lg-3 item';
                });
            });
        });

        fullButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const itemsContainer = document.querySelectorAll('.items-container')[index];
                const items = itemsContainer.querySelectorAll('.item');
                //  selectButton(fullButtons, button, compactButtons);

                $('.items-container .add-item').show();

                items.forEach(item => {
                    const id = item.dataset.itemId;
                    const name = item.dataset.itemName;
                    const description = item.dataset.itemDescription;
                    const price = item.dataset.itemPrice;
                    const logom = item.dataset.itemLogom;
                    const available = item.dataset.itemAvailability;
                    const availableinlang = item.dataset.itemAvailabilityinlang;

                    const availabilityText = available == 1 ?
                        `<span class="text-success">{{ __('AVAILABLE') }}</span>` :
                        `<span class="text-danger">{{ __('UNAVAILABLE') }}</span>`;
                    const availabilityInLangText = availableinlang == 1 ?
                        `<small class="text-success">Item active</small>` :
                        `<small class="text-danger">Item inactive</small>`;

                    item.innerHTML = `
                        <a href="/items/${id}/edit">
                            <div class="card">
                                <img class="card-img-top" src="${logom}" alt="...">
                                <div class="card-body">
                                    <h3 class="card-title text-primary text-uppercase">${name}</h3>
                                    <p class="card-text description mt-3">${description}</p>
                                    <span class="badge badge-primary badge-pill">${price}</span>
                                    <p class="mt-3 mb-0 text-sm">${availabilityText} || ${availabilityInLangText}</p>
                                </div>
                            </div>
                            <br />
                        </a>
                    `;
                    item.className = 'col-lg-3 item';
                });
            });
        });

        // function selectButton(buttons, selectedBtn, removedBtn) {
        //     buttons.forEach((button) => {
        //         button.classList.remove('btn-success');
        //         button.classList.add('btn-primary');
        //     });
        //     selectedBtn.classList.remove('btn-primary');
        //     selectedBtn.classList.add('btn-success');
        //     removedBtn.classList.remove('btn-success');
        //     removedBtn.classList.add('btn-primary');
        // }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryContainers = document.querySelectorAll('.category-items');

            categoryContainers.forEach(container => {
                new Sortable(container, {
                    animation: 150,
                    onEnd: function(evt) {
                        const categoryId = evt.to.dataset.categoryId;
                        var items = Array.from(evt.to.children).map(item => item.dataset
                            .itemId);

                        //Remove any item that is null
                        items = items.filter(item => item != null);

                        console.log(items);

                        fetch('{{ route('items.reorderitems') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    items: items
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Items reordered successfully');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    </script>
@endsection

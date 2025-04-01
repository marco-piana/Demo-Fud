<!-- section-place-content -->
<section class='section section-place-content'>
    @if (!$restorant->categories->isEmpty())
        <div class='bg-white nav-menu sticky_horizontal'>
            <div class='packer'>
                <div class="package">
                    <nav id='place-menu' class="flex content-tab expanded">
                        <div class='item'>
                            <a data-toggle="modal" data-target="#searchModal" href='javascript:;'>
                                <svg height="19" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 18c1.846 0 3.54-.64 4.89-1.69l4.39 4.39 1.41-1.42 -4.4-4.4c1.05-1.36 1.689-3.06 1.689-4.898 0-4.42-3.59-8-8-8 -4.42 0-8 3.58-8 8 0 4.411 3.58 8 8 8Zm0-14c3.3 0 6 2.691 6 6 0 3.3-2.7 6-6 6 -3.31 0-6-2.7-6-6 0-3.31 2.691-6 6-6Z" />
                                </svg>
                            </a>
                        </div>
                        @foreach ($restorant->categories as $key => $category)
                            @if (!$category->items->isEmpty())
                                <div class='item'>
                                    <a class="" href='#subsection-<?php echo $category->id; ?>'><?php echo $category->name; ?></a>
                                </div>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    @endif
    <div class='packer'>
        <div class='package'>
            <div class='content'>
                <div class="row">
                    <div class="col-xl-9">
                        <!-- tab menu -->
                        <div class='holder-left content-tab expanded'>
                            <div class='content-center'>
                                @if (!$restorant->categories->isEmpty())
                                    @foreach ($restorant->categories as $key => $category)
                                        <div id='subsection-<?php echo $category->id; ?>' class='box-info'>
                                            <div class='head'>
                                                <h3 class="mb-0"><?php echo $category->name; ?></h3>
                                            </div>
                                            <div class='content grid'>
                                                {{-- Brij Negi Update --}}
                                                @php $counter = 0; @endphp
                                                @foreach ($category->aitems as $item)
                                                    @if ($item->is_available_for_lang == 0)
                                                        @continue
                                                    @endif
                                                    @php $counter++; @endphp
                                                    @if ($item->qty_management == 1 && $item->qty < 1)
                                                        <a href='javascript:;' disabled
                                                            class='item-offer-horizontal disabled'>
                                                            <div class="no-stock">
                                                                <span>{{ __('Out of stock') }}</span>
                                                            </div>
                                                        @else
                                                            <a href='javascript:;'
                                                                onClick="setCurrentItem({{ $item->id }})"
                                                                class='item-offer-horizontal'>
                                                    @endif
                                                    <div class='info'>
                                                        <h6 class="title">{{ $counter }}. {{ $item->name }}
                                                        </h6>
                                                        {{-- Brij Negi Update --}}
                                                        <p>{{ $item->description }}</p>
                                                        <div class='extras'>
                                                            <div class='price'>
                                                                @money($item->price, config('settings.cashier_currency'), config('settings.do_convertion'))
                                                                @if ($item->discounted_price > 0)
                                                                    <span>@money($item->discounted_price, config('settings.cashier_currency'), config('settings.do_convertion'))</span>
                                                                @endif
                                                            </div>
                                                            <div class="allergens">
                                                                @foreach ($item->allergens as $allergen)
                                                                    <div class='allergen' data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="{{ $allergen->title }}">
                                                                        <img src="{{ $allergen->image_link }}" />
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (strlen($item->logom) > 5)
                                                        <picture>
                                                            <source srcset="{{ $item->logom }}"
                                                                media="(min-width: 569px)" />
                                                            <img loading="lazy" src='{{ $item->logom }}' />
                                                        </picture>
                                                    @endif
                                                    @if ($item->discounted_price > 0)
                                                        <div class="absolute offer-label">
                                                            <svg viewBox="0 0 24 24" fill="#ffb232" width="42"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill="#FFF"
                                                                    d="M12 11.222l2.667 1.77 -.89-3.12 2.22-1.89 -2.667-.34 -1.34-2.67 -1.34 2.66 -2.667.33 2.22 1.88 -.89 3.11Z" />
                                                                <path
                                                                    d="M19 21.723V9.99v-1 -5c0-1.104-.9-2-2-2H7c-1.104 0-2 .89-2 2v5 1 11.72l7-4.58 7 4.57ZM8 7.99l2.667-.34 1.33-2.667 1.33 2.667 2.667.33 -2.23 1.88 .89 3.11 -2.667-1.78 -2.667 1.77 .89-3.12 -2.23-1.89Z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row justify-content-center ">
                                        <div class="w-100 ">
                                            <div class="text-center">
                                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                <lottie-player
                                                    src="https://assets1.lottiefiles.com/packages/lf20_mznpnepo.json"
                                                    background="transparent" speed="1"
                                                    style="width: 100%; height: auto;" loop autoplay></lottie-player>
                                            </div>
                                            <h1 class="text-muted text-center">{{ __('Hmmm... Nothing found!') }}</h1>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        @if (isset($canDoOrdering) ? $canDoOrdering : true)
                            <div class="btn_reserve_fixed" id="cartButtonHolder"><a href="#0"
                                    class="btn_1 gradient full-width" id="theCartBottomButton"
                                    onClick="openNav()">{{ __('Order Summary') }} <span v-if="counter>0">(
                                        @{{ counter }} )</span></a></div>
                        @endif
                        <div class='holder-right mb-3'>
                            {{-- Brij Negi Update --}}
                            @if ($forceLogin === 'yes' && session()->has('UserViewer'))
                                @include('luxe-template::templates.logged_in_user')
                            @endif
                            @if ($canDoOrdering)
                                @include('luxe-template::templates.side_cart', [
                                    'id' => 'cartList',
                                    'idtotal' => 'totalPrices',
                                ])
                            @endif
                            @include('luxe-template::templates.hours')
                            <div class="about-us text-center">
                                @if (isset($doWeHaveImpressumApp) && $doWeHaveImpressumApp && strlen($restorant->getConfig('impressum_value', '')) > 5)
                                    <div class="impressum">
                                        <h6>{{ $restorant->getConfig('impressum_title', '') }}</h6>
                                        <p><small><?php echo $restorant->getConfig('impressum_value', ''); ?>.</small></p>
                                    </div>
                                @endif

                                <div class="social-buttons mb-4">
                                    <!-- Display Social media links -->

                                    <?php
                                    //Ge the social media links from company
                                    $facebook = $restorant->getConfig('facebook', '');
                                    $instagram = $restorant->getConfig('instagram', '');
                                    $twitter = $restorant->getConfig('twitter', '');
                                    $youtube = $restorant->getConfig('youtube', '');
                                    $website = $restorant->getConfig('website', '');
                                    $phone = $restorant->phone;
                                    $whatsapp_phone = $restorant->whatsapp_phone;
                                    $whatsapp = preg_replace('/[^\dxX]/', '', $whatsapp_phone);
                                    ?>

                                    <div class="flex flex-row justify-content-center">
                                        <!-- Facebook Button -->
                                        @if (strlen($facebook) > 2)
                                            <div class='item'>
                                                <a href='{{ $facebook }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.001 2C6.47 2 2 6.477 2 11.99c0 4.99 3.65 9.126 8.437 9.879v-6.99H7.89v-2.9h2.54V9.76c0-2.51 1.49-3.9 3.776-3.9 1.09 0 2.24.19 2.24.19V8.5h-1.27c-1.24 0-1.63.77-1.63 1.56v1.875h2.77l-.45 2.89h-2.33v6.98c4.78-.75 8.437-4.89 8.437-9.877 0-5.53-4.477-10-9.999-10Z" />
                                                    </svg>

                                                </a>
                                            </div>
                                        @endif

                                        <!-- Instagram Button -->
                                        @if (strlen($instagram) > 2)
                                            <div class='item'>
                                                <a href='{{ $instagram }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path
                                                                d="M20.947 8.3c-.02-.76-.16-1.508-.42-2.22 -.47-1.21-1.43-2.165-2.64-2.633 -.7-.27-1.44-.41-2.186-.42 -.97-.05-1.27-.06-3.71-.06 -2.442 0-2.76 0-3.71.05 -.75.01-1.49.15-2.19.42 -1.21.46-2.17 1.424-2.64 2.63 -.27.69-.41 1.43-.42 2.18 -.05.96-.06 1.26-.06 3.71 0 2.442 0 2.75.05 3.71 .01.74.15 1.48.41 2.18 .46 1.2 1.424 2.16 2.634 2.63 .69.27 1.43.42 2.18.45 .96.04 1.26.05 3.71.05 2.442 0 2.75 0 3.71-.06 .74-.02 1.48-.16 2.186-.42 1.2-.47 2.16-1.43 2.63-2.64 .26-.7.4-1.44.41-2.19 .04-.97.05-1.27.05-3.71 -.01-2.45-.01-2.76-.06-3.71Zm-8.953 8.29c-2.56 0-4.63-2.07-4.63-4.63s2.06-4.63 4.62-4.63c2.55 0 4.62 2.06 4.62 4.62 0 2.55-2.08 4.62-4.63 4.62Zm4.8-8.339c-.6 0-1.08-.49-1.08-1.08 0-.6.48-1.08 1.07-1.08 .59 0 1.07.48 1.07 1.07 0 .59-.49 1.07-1.08 1.07Z" />
                                                            <path
                                                                d="M11.994 8.976a3.003 3.003 0 1 0 0 6.006 3.003 3.003 0 1 0 0-6.006Z" />
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Youtube Button -->
                                        @if (strlen($youtube) > 2)
                                            <div class='item'>
                                                <a href='{{ $youtube }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M21.593 7.2c-.23-.86-.91-1.54-1.77-1.766 -1.57-.43-7.84-.44-7.84-.44s-6.27-.01-7.831.4c-.84.22-1.54.92-1.766 1.77 -.42 1.56-.42 4.81-.42 4.81s-.01 3.26.4 4.814c.23.85.9 1.53 1.763 1.76 1.58.43 7.83.43 7.83.43s6.26 0 7.83-.41c.85-.23 1.53-.91 1.76-1.77 .41-1.57.41-4.82.41-4.82s.02-3.27-.41-4.84ZM9.996 15l0-6 5.2 3 -5.22 2.99Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Twitter Button -->
                                        @if (strlen($twitter) > 2)
                                            <div class='item'>
                                                <a href='{{ $twitter }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 512 512"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8l164.9-188.5L26.8 48h145.6l100.5 132.9L389.2 48Zm-24.8 373.8h39.1L151.1 88h-42l255.3 333.8Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Phone button -->
                                        @if (strlen($phone) > 2)
                                            <div class='item'>
                                                <a href='tel:{{ $phone }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M20.487 17.14l-4.07-3.7c-.4-.37-1.02-.35-1.391.04l-2.4 2.46c-.58-.11-1.734-.48-2.926-1.66 -1.2-1.2-1.56-2.36-1.66-2.926l2.45-2.394c.38-.38.4-1 .04-1.391L6.83 3.5c-.37-.41-.98-.44-1.391-.09L3.26 5.27c-.18.17-.28.4-.29.64 -.02.25-.31 6.17 4.291 10.76 4.006 4 9.024 4.29 10.4 4.29 .2 0 .32-.01.35-.01 .24-.02.47-.12.64-.3l1.86-2.18c.35-.42.31-1.03-.09-1.39Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Website Button -->
                                        @if (strlen($website) > 2)
                                            <div class='item'>
                                                <a href='{{ $website }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12c0 5.51 4.48 10 10 10 5.51 0 10-4.49 10-10 0-5.52-4.49-10-10-10Zm7.93 9h-2.77c-.12-2.17-.73-4.3-1.8-6.243 2.43 1.141 4.2 3.47 4.55 6.243Zm-7.41-6.98c1.03 1.36 2.42 3.78 2.62 6.97H9.01C9.14 8.39 10 5.96 11.46 4.01c.17-.01.34-.03.51-.03 .17 0 .35.01.53.02Zm-3.85.7c-.99 1.891-1.56 4.03-1.66 6.27H4.04c.35-2.8 2.14-5.15 4.61-6.28ZM4.05 12.99h2.97c.13 2.37.665 4.47 1.55 6.23 -2.43-1.15-4.183-3.468-4.53-6.23Zm7.38 6.97c-1.41-1.7-2.23-4.08-2.41-6.98h6.11c-.21 2.77-1.12 5.19-2.61 6.97 -.19.01-.37.02-.56.02 -.19 0-.37-.02-.55-.03Zm4.01-.78c.95-1.8 1.53-3.901 1.69-6.21h2.77c-.35 2.73-2.08 5.04-4.47 6.2Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif


                                        <!-- WhatsApp button -->
                                        @if (strlen($whatsapp_phone) > 2)
                                            <div class='item'>
                                                <a href='https://wa.me/{{ $whatsapp }}'>
                                                    <svg width="24" fill="#868686" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M18.403 5.633c-1.7-1.7-3.95-2.632-6.35-2.633C7.1 3 3.07 7.02 3.07 11.977c0 1.58.41 3.12 1.19 4.48l-1.28 4.65 4.759-1.25c1.31.71 2.78 1.09 4.29 1.093h0v0c4.94 0 8.975-4.03 8.97-8.977 0-2.4-.94-4.66-2.63-6.35m-6.35 13.81h-.01c-1.34-.01-2.66-.36-3.798-1.05l-.28-.17 -2.824.74 .75-2.753 -.18-.29C4.93 14.72 4.54 13.34 4.54 11.93c0-4.12 3.349-7.461 7.465-7.461 1.99 0 3.86.77 5.27 2.18 1.4 1.41 2.18 3.285 2.183 5.279 -.01 4.11-3.35 7.462-7.47 7.462m4.093-5.59c-.23-.12-1.327-.66-1.54-.73 -.21-.08-.36-.12-.51.11 -.15.22-.58.72-.72.87 -.14.15-.27.16-.49.05 -.23-.12-.95-.35-1.81-1.12 -.67-.6-1.12-1.33-1.25-1.56 -.14-.23-.02-.35.09-.46 .1-.1.22-.27.33-.4 .11-.14.14-.23.22-.38 .07-.15.03-.29-.02-.4 -.06-.12-.51-1.22-.7-1.67 -.19-.44-.37-.38-.51-.39 -.13-.01-.28-.01-.43-.01 -.15 0-.4.05-.6.28 -.21.22-.79.76-.79 1.87 0 1.1.8 2.17.91 2.32 .11.15 1.58 2.41 3.83 3.38 .53.23.95.36 1.279.47 .53.17 1.02.14 1.41.08 .43-.07 1.327-.55 1.51-1.07 .18-.53.18-.98.13-1.07 -.06-.1-.21-.16-.43-.27" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                <h6 class="text-center"><small>{{ __('Powered by') }} <a href="/"
                                            target="_blank"
                                            rel="noopener noreferrer">{{ config('global.site_name') }}</a></small>
                                </h6>
                                @if (!config('settings.single_mode') && config('settings.restaurant_link_register_position') == 'footer')
                                    <a target="_blank" class="nav-link"
                                        href="{{ route('newrestaurant.register') }}">{{ __('Add your Restaurant') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

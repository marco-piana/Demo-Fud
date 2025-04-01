<!-- mobile-menu -->
<section id='mobile-menu'>
    <a class="close-mobile-menu" href="javascript:;" onclick="openNav()"><svg width="24" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M16.192 6.34l-4.243 4.24 -4.242-4.25 -1.42 1.41 4.242 4.242 -4.242 4.24 1.41 1.41 4.242-4.25 4.243 4.24 1.41-1.42 -4.25-4.25 4.24-4.242Z" />
        </svg></a>
    <div class='content'>
        <div class="flex flex-col h-100 justify-content-between" style="max-height:98vh">

            @if ($canDoOrdering)
                @include('luxe-template::templates.side_cart', [
                    'id' => 'cartListMobile',
                    'idtotal' => 'totalPricesMobile',
                ])
            @endif
            <div class="about-us text-center">
                <nav>
                    <!-- Buttons -->
                    @isset($restorant)
                        @if (config('app.isqrsaas'))
                            @if (config('settings.enable_guest_log'))
                                <!-- Register Visit -->
                                <a href="{{ route('register.visit', ['restaurant_id' => $restorant->id]) }}"
                                    class="d-flex btn_hero"> <svg width="16" fill="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19 2.01H6c-1.21 0-3 .79-3 3v3 6 3 2c0 2.2 1.79 3 3 3h15v-2H6.01c-.47-.02-1.02-.2-1.02-1 0-.11 0-.2.02-.28 .11-.58.58-.72.98-.73h13.989c.01 0 .03-.01.04-.01h.95V17v-2.01V4c0-1.11-.9-2-2-2Zm0 14H5v-2 -6 -3c0-.806.55-.99 1-1h7v7l2-1 2 1v-7h2V15v1.01Z" />
                                    </svg>&nbsp;{{ __('Register visit') }}</a>
                            @endif
                            @if (isset($_GET['tid']))
                                @if (
                                    !config('settings.is_whatsapp_ordering_mode') &&
                                        !$restorant->getConfig('disable_callwaiter', 0) &&
                                        strlen(config('broadcasting.connections.pusher.app_id')) > 2 &&
                                        strlen(config('broadcasting.connections.pusher.key')) > 2 &&
                                        strlen(config('broadcasting.connections.pusher.secret')) > 2)
                                    <!-- Waiter -->
                                    <a data-toggle="modal" data-target="#modal-form" href='javascript:;'
                                        class='d-flex btn_hero'><svg width="16" fill="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 15c0-4.625-3.51-8.45-8-8.95V3.99h-2v2.05c-4.493.5-8 4.31-8 8.941v2h18v-2ZM5 15c0-3.859 3.141-7 7-7s7 3.141 7 7H5Zm-3 3h20v2H2Z" />
                                        </svg>&nbsp;{{ __('Call Waiter') }}</a>
                                @endif
                            @endif
                            @if ($canDoOrdering && $restorant->getConfig('clients_enable', 'false') != 'false')
                                <!-- Login -->
                                <a href="{{ route('login') }}?showCreate=true" class='d-flex btn_hero'><svg
                                        fill="currentColor" width="16" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="none" d="M12 4a3 3 0 1 0 0 6 3 3 0 1 0 0-6Z" />
                                        <path
                                            d="M12 2C9.24 2 7 4.24 7 7c0 2.75 2.24 5 5 5 2.75 0 5-2.25 5-5 0-2.76-2.25-5-5-5Zm0 8c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3 -1.346 3-3 3Zm9 11v-1c0-3.86-3.15-7-7-7h-4c-3.86 0-7 3.14-7 7v1h2v-1c0-2.76 2.24-5 5-5h4c2.75 0 5 2.24 5 5v1h2Z" />
                                    </svg>&nbsp;{{ __('Login') }}</a>
                            @elseif(isset($hasGuestOrders) && $hasGuestOrders && $canDoOrdering)
                                <!-- Guest order -->
                                <a href="{{ route('guest.orders') }}"class="d-flex btn_hero"> <svg width="16"
                                        fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path
                                                d="M21 5c0-1.11-.9-2-2-2H5c-1.11 0-2 .89-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5ZM5 19V5h14l0 14H4.99Z" />
                                            <path
                                                d="M7 7h1.99v2h-2Zm4 0h6v2h-6Zm-4 4h1.99v2h-2Zm4 0h6v2h-6Zm-4 4h1.99v2h-2Zm4 0h6v2h-6Z" />
                                        </g>
                                    </svg>&nbsp;{{ __('My Orders') }}</a>
                            @endif

                        @endif
                        @if (config('app.isft') || config('settings.social_mode'))
                            <!-- Phone -->
                            <a href="tel:+{{ $restorant->phone }}" class='d-flex btn_hero'><svg fill="currentColor"
                                    width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.707 12.293c-.4-.391-1.03-.391-1.42 0l-1.6 1.59c-.74-.22-2.12-.72-3-1.6 -.88-.88-1.38-2.253-1.6-3l1.59-1.6c.391-.391.391-1.03 0-1.42l-4-4c-.391-.4-1.03-.4-1.42-.001L3.53 4.974c-.38.38-.6.9-.59 1.43 .02 1.42.4 6.37 4.298 10.26 3.89 3.89 8.84 4.27 10.26 4.29 0 0 .02 0 .02 0 .52 0 1.02-.21 1.4-.59l2.71-2.72c.39-.4.39-1.03 0-1.42l-4-4.01Zm-.13 6.71c-1.25-.03-5.52-.36-8.88-3.72C5.32 11.913 5 7.632 4.977 6.4l2-2.01 2.58 2.58 -1.3 1.29c-.24.23-.35.58-.28.91 .02.11.61 2.84 2.27 4.5 1.66 1.66 4.38 2.247 4.5 2.27 .33.07.67-.04.91-.28l1.29-1.3 2.58 2.58 -2.01 2Z" />
                                </svg>&nbsp;{{ __('Call') }}</a>
                        @endif
                        @if (\Akaunting\Module\Facade::has('cards') && $restorant->getConfig('enable_loyalty', false))
                            <!-- Loyalty  -->
                            <a href="{{ route('loyalty.landing', ['alias' => $restorant->subdomain]) }}"
                                class="d-flex btn_hero"><svg fill="currentColor" height="15" viewBox="0 0 512 512"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M231.9 44.4C215.7 16.9 186.1 0 154.2 0H152c-48.6 0-88 39.4-88 88 0 14.4 3.5 28 9.6 40H48c-26.5 0-48 21.5-48 48v64c0 20.9 13.4 38.7 32 45.3v2.7 160c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64V288v-2.7c18.6-6.6 32-24.4 32-45.3v-64c0-26.5-21.5-48-48-48h-25.6c6.1-12 9.6-25.6 9.6-40 0-48.6-39.4-88-88-88h-2.2c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41ZM464 176v64h-32H288v-64h72 104Zm-240 0v64H80 48v-64h104 72Zm0 112v176H96c-8.8 0-16-7.2-16-16V288h144Zm64 176V288h144v160c0 8.8-7.2 16-16 16H288Zm72-336h-72 -1.3l34.8-59.2c7.6-12.9 21.4-20.8 36.3-20.8h2.2c22.1 0 40 17.9 40 40s-17.9 40-40 40Zm-136 0h-72c-22.1 0-40-17.9-40-40s17.9-40 40-40h2.2c14.9 0 28.8 7.9 36.3 20.8l34.8 59.2H224Z" />
                                </svg>&nbsp;{{ __('loyalty.loyalty_program') }}</a>
                        @endif
                    @endisset

                    @yield('addiitional_button_1_mobile')
                    @yield('addiitional_button_2_mobile')
                    <!--- End buttons -->
                    @if (isset($showGoogleTranslate) && $showGoogleTranslate && !$showLanguagesSelector)
                        <!-- Google Translate -->
                        @include('googletranslate::buttons')
                    @endif
                    <!--- Languages -->
                    @if ($showLanguagesSelector)
                        <div class='item has-submenu'>
                            <a href='javascript:;'>{{ $currentLanguage }}<span class='toggle-submenu'><i
                                        class="las la-angle-down"></i></span></a>
                            <div class='submenu'>
                                @foreach ($restorant->localmenus()->get() as $language)
                                    @if ($language->language != config('app.locale'))
                                        <div class='item'><a
                                                href='?lang={{ $language->language }}'>{{ $language->languageName }}</a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </nav>
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
                        @if (strlen($facebook) > 2)
                            <!-- Facebook Button -->
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

                        @if (strlen($instagram) > 2)
                            <!-- Instagram Button -->
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

                        @if (strlen($youtube) > 2)
                            <!-- Youtube Button -->
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

                <h6 class="text-center"><small>{{ __('Powered by') }} <a href="/" target="_blank"
                            rel="noopener noreferrer">{{ config('global.site_name') }}</a></small></h6>
                @if (!config('settings.single_mode') && config('settings.restaurant_link_register_position') == 'footer')
                    <a target="_blank" class="nav-link"
                        href="{{ route('newrestaurant.register') }}">{{ __('Add your Restaurant') }}</a>
                @endif
            </div>
        </div>
    </div>
</section>

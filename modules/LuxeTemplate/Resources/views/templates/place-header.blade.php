
<!-- place-header -->
<section class='section section-place-header'>
    <div class='packer h-100 d-flex flex-column justify-content-end'>
    @isset($restorant)
        @yield('addiitional_button_1')
        @yield('addiitional_button_2')
        @if (isset($showGoogleTranslate)&&$showGoogleTranslate&&!$showLanguagesSelector)
            <!--- Languages -->
            @include('googletranslate::buttons')
        @endif
        @if ($showLanguagesSelector)
        <!--- Languages -->
        <div class="select-lang">
            <div class='dropdown'>
                <a class='dropdown-toggle' href='javascript:;'>{{ $currentLanguage }}</a>
                <div class='dropdown-menu'>
                    <div class='dropdown-menu-title'>{{ __('Select Language') }}</div>
                    @foreach ($restorant->localmenus()->get() as $language)
                        @if ($language->language!=config('app.locale'))
                            <a href='?lang={{ $language->language }}'>{{$language->languageName}}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    @endisset
        
        <!-- End Languages -->
        <div class='package d-flex justify-content-between align-items-end hero-header'>
            <div class='text-left text-center-sm header-align'>
                <picture class='avatar'><img loading="lazy" src='{{ $restorant->icon }}' /></picture>
                <div class='info '>
                    <h1 class="notranslate text-white">{{ $restorant->name }}</h1>
                    @php
                        $cityId = $restorant->city_id;
                        $city = DB::table('cities')->select('name')->where(['id' => $cityId])->value('name');
                    @endphp
                    <p class="opacity-9 text-white title_small mb-0">{{ $restorant->description }}</p>
                    <p class="text-white mt-0 mb-0">
                        @if ($city != ''){{ $city }} –@endif <a href="https://maps.google.com/maps?q={{ $restorant->address }}" class="text-white header-link" target="_blank" rel="noopener noreferrer">{{ __('Get Directions') }}</a>
                    </p>
                    @if(config('app.isft'))
                        @if(count($restorant->ratings))
                        <div class="ratings ">
                            <span class="d-flex font-medium text-white"><svg width="16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0.552342 -26.2649 14.6453 14.0149"><path d="M7.08201-25.7727l-1.77734 3.60937 -3.99218.601561c-.364582.0364581-.601561.227864-.710936.574217 -.109375.346353-.0364581.647134.218749.902342l2.89843 2.8164 -.683592 3.99218c-.0546874.346353.0638018.628905.355468.847654 .291666.218749.592447.236979.902342.0546874l3.58202-1.85937 3.58202 1.85937c.309895.164062.610675.141276.902342-.0683592 .291666-.209635.410155-.487629.355468-.833982l-.683592-3.99218 2.89843-2.8164c.255208-.255208.328124-.555988.218749-.902342 -.109375-.346353-.346353-.537759-.710936-.574217l-3.99218-.601561 -1.77734-3.60937c-.164062-.328124-.428385-.492186-.792967-.492186 -.364582 0-.628905.164062-.792967.492186Z" fill="#fbb851"></path></svg>&nbsp;<strong>{{ number_format($restorant->averageRating, 1, '.', ',') }} <span class="small">/ 5 ({{ count($restorant->ratings) }})</strong></span></span>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="header-buttons">                
                <!-- Buttons -->
                @isset($restorant)
                    @if(config('app.isqrsaas'))
                        @if(config('settings.enable_guest_log'))
                            <!-- Register Visit -->
                            <a href="{{ route('register.visit',['restaurant_id'=>$restorant->id])}}" class="d-flex btn_hero"> <svg width="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 2.01H6c-1.21 0-3 .79-3 3v3 6 3 2c0 2.2 1.79 3 3 3h15v-2H6.01c-.47-.02-1.02-.2-1.02-1 0-.11 0-.2.02-.28 .11-.58.58-.72.98-.73h13.989c.01 0 .03-.01.04-.01h.95V17v-2.01V4c0-1.11-.9-2-2-2Zm0 14H5v-2 -6 -3c0-.806.55-.99 1-1h7v7l2-1 2 1v-7h2V15v1.01Z"/></svg>&nbsp;{{ __('Register visit') }}</a>
                        @endif
                        @if ($canDoOrdering&&$restorant->getConfig('clients_enable','false')=='true')
                            <!-- Login -->
                            <a href="{{ route('login')}}?showCreate=true" class='d-flex btn_hero'><svg fill="currentColor" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M12 4a3 3 0 1 0 0 6 3 3 0 1 0 0-6Z"/><path d="M12 2C9.24 2 7 4.24 7 7c0 2.75 2.24 5 5 5 2.75 0 5-2.25 5-5 0-2.76-2.25-5-5-5Zm0 8c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3 -1.346 3-3 3Zm9 11v-1c0-3.86-3.15-7-7-7h-4c-3.86 0-7 3.14-7 7v1h2v-1c0-2.76 2.24-5 5-5h4c2.75 0 5 2.24 5 5v1h2Z"/></svg>&nbsp;{{ __('Login') }}</a>
                        @elseif(isset($hasGuestOrders)&&$hasGuestOrders)
                            <!-- Guest order -->
                            <a href="{{ route('guest.orders') }}"class="d-flex btn_hero"> <svg width="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M21 5c0-1.11-.9-2-2-2H5c-1.11 0-2 .89-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5ZM5 19V5h14l0 14H4.99Z"/><path d="M7 7h1.99v2h-2Zm4 0h6v2h-6Zm-4 4h1.99v2h-2Zm4 0h6v2h-6Zm-4 4h1.99v2h-2Zm4 0h6v2h-6Z"/></g></svg>&nbsp;{{ __('My Orders') }}</a>
                        @endif
                        
                    @endif
                    @if (!$restorant->getConfig('disable_callwaiter',false))
                        <!-- Waiter -->
                        <a data-toggle="modal" data-target="#modal-form" href='javascript:;' class='d-flex btn_hero'><svg width="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21 15c0-4.625-3.51-8.45-8-8.95V3.99h-2v2.05c-4.493.5-8 4.31-8 8.941v2h18v-2ZM5 15c0-3.859 3.141-7 7-7s7 3.141 7 7H5Zm-3 3h20v2H2Z"/></svg>&nbsp;{{ __('Call Waiter') }}</a> 
                    @endif
                    @if(config('app.isft') || config('settings.social_mode'))
                        <!-- Phone -->
                        <a href="tel:+{{ $restorant->phone }}" class='d-flex btn_hero'><svg fill="currentColor" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.707 12.293c-.4-.391-1.03-.391-1.42 0l-1.6 1.59c-.74-.22-2.12-.72-3-1.6 -.88-.88-1.38-2.253-1.6-3l1.59-1.6c.391-.391.391-1.03 0-1.42l-4-4c-.391-.4-1.03-.4-1.42-.001L3.53 4.974c-.38.38-.6.9-.59 1.43 .02 1.42.4 6.37 4.298 10.26 3.89 3.89 8.84 4.27 10.26 4.29 0 0 .02 0 .02 0 .52 0 1.02-.21 1.4-.59l2.71-2.72c.39-.4.39-1.03 0-1.42l-4-4.01Zm-.13 6.71c-1.25-.03-5.52-.36-8.88-3.72C5.32 11.913 5 7.632 4.977 6.4l2-2.01 2.58 2.58 -1.3 1.29c-.24.23-.35.58-.28.91 .02.11.61 2.84 2.27 4.5 1.66 1.66 4.38 2.247 4.5 2.27 .33.07.67-.04.91-.28l1.29-1.3 2.58 2.58 -2.01 2Z"/></svg>&nbsp;{{ __('Call') }}</a>
                    @endif
                    @if (\Akaunting\Module\Facade::has('cards')&&$restorant->getConfig('enable_loyalty', false))
                        <!-- Loyalty  -->
                        <a href="{{ route('loyalty.landing',['alias'=>$restorant->subdomain])}}" class="d-flex btn_hero"><svg fill="currentColor" height="15" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M231.9 44.4C215.7 16.9 186.1 0 154.2 0H152c-48.6 0-88 39.4-88 88 0 14.4 3.5 28 9.6 40H48c-26.5 0-48 21.5-48 48v64c0 20.9 13.4 38.7 32 45.3v2.7 160c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64V288v-2.7c18.6-6.6 32-24.4 32-45.3v-64c0-26.5-21.5-48-48-48h-25.6c6.1-12 9.6-25.6 9.6-40 0-48.6-39.4-88-88-88h-2.2c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41ZM464 176v64h-32H288v-64h72 104Zm-240 0v64H80 48v-64h104 72Zm0 112v176H96c-8.8 0-16-7.2-16-16V288h144Zm64 176V288h144v160c0 8.8-7.2 16-16 16H288Zm72-336h-72 -1.3l34.8-59.2c7.6-12.9 21.4-20.8 36.3-20.8h2.2c22.1 0 40 17.9 40 40s-17.9 40-40 40Zm-136 0h-72c-22.1 0-40-17.9-40-40s17.9-40 40-40h2.2c14.9 0 28.8 7.9 36.3 20.8l34.8 59.2H224Z"/></svg>&nbsp;{{  __('loyalty.loyalty_program') }}</a>
                    @endif
                @endisset
                <!--- End buttons -->
            </div>
        </div>
    </div>
    <picture data-background=true >
        <source  srcset="{{ $restorant->coverm }}" media="(min-width: 569px)" />
        <img class="grayscale-05" loading="lazy" src='{{ $restorant->coverm }}' />        
    </picture>
</section>

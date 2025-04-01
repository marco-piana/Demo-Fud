<section class="relative w-full bg-top bg-cover md:bg-center" x-data="{ showMenu: false }" style="background-image:url('{{ $company->getCovermAttribute() }}')" data-tails-scripts="//unpkg.com/alpinejs" >
    <div class="absolute inset-0 w-full h-full bg-gray-900 opacity-25"></div>
    <div class="absolute inset-0 w-full h-64 opacity-50 bg-gradient-to-b from-black to-transparent"></div>
    <div class="relative flex items-center justify-between w-full h-20 px-8">

        <a href="{{ $company->getLinkAttribute() }}" class="relative flex items-center h-full pr-6 text-lg font-extrabold text-white">{{ $company->name }}</a>
        <nav class="flex-col items-center justify-center hidden h-full space-y-3 bg-white md:justify-end md:bg-transparent md:space-x-5 md:space-y-0 md:relative md:flex md:flex-row" :class="{'flex fixed top-0 left-0 w-full z-40': showMenu, 'hidden': !showMenu }">
            <!-- <a href="#_" class="relative text-lg font-medium tracking-wide text-green-400 transition duration-150 ease-out md:text-sm md:text-white" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" data-primary="green-400">
                <span class="block">Home</span>
                <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                    <span x-show="hover" class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-green-400" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0" data-primary="green-400" style="display: none;"></span>
                </span>
            </a>
            <a href="#_" class="relative text-lg font-medium tracking-wide text-green-400 transition duration-150 ease-out md:text-white md:text-sm" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" data-primary="green-400">
                <span class="block">How to use points</span>
                <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                    <span x-show="hover" class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-green-400" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0" data-primary="green-400" style="display: none;"></span>
                </span>
            </a>
            <a href="#_" class="relative text-lg font-medium tracking-wide text-green-400 transition duration-150 ease-out md:text-white md:text-sm" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" data-primary="green-400">
                <span class="block">How to get points</span>
                <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                    <span x-show="hover" class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-green-400" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0" data-primary="green-400" style="display: none;"></span>
                </span>
            </a> -->
            <a href="#faq" class="relative text-lg font-medium tracking-wide text-green-400 transition duration-150 ease-out md:text-white md:text-sm" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" data-primary="green-400">
                <span class="block">{{ __('FAQ') }}</span>
                <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                    <span x-show="hover" class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-green-400" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0" data-primary="green-400" style="display: none;"></span>
                </span>
            </a>
            <!-- <a href="#_" class="relative text-lg font-medium tracking-wide text-green-400 transition duration-150 ease-out md:text-sm md:text-white" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" data-primary="green-400">
                <span class="block">Contact</span>
                <span class="absolute bottom-0 left-0 inline-block w-full h-1 -mb-1 overflow-hidden">
                    <span x-show="hover" class="absolute inset-0 inline-block w-full h-1 h-full transform border-t-2 border-green-400" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0" data-primary="green-400" style="display: none;"></span>
                </span>
            </a>-->
            @auth
                <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-sm font-medium tracking-normal text-white transition duration-150 bg-green-400 rounded hover:bg-green-500 ease" data-rounded="rounded" data-primary="green-400">
                    <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" class=""></path>
                    </svg>
                    {{ __('Dashboard') }}
                </a>
            @endauth
            @guest
                <a href="{{ route('login',['showCreate'=>"true"]) }}" class="flex items-center px-3 py-2 text-sm font-medium tracking-normal text-white transition duration-150 bg-green-400 rounded hover:bg-green-500 ease" data-rounded="rounded" data-primary="green-400">
                    <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" class=""></path>
                    </svg>
                    {{ __('Login') }}
                </a>
            @endguest
            
        </nav>

        <!-- Mobile Nav  -->
        <nav class="fixed top-0 right-0 z-30 z-50 flex w-10 h-10 mt-4 mr-4 md:hidden">
            <button @click="showMenu = !showMenu" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-white hover:bg-opacity-25 focus:outline-none">
                <svg class="w-5 h-5 text-gray-200 fill-current" x-show="!showMenu" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg>
                <svg class="w-5 h-5 text-gray-500" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </nav>
        <!-- End Mobile Nav -->
    </div>
    <div class="relative z-10 max-w-6xl px-10 py-40 mx-auto">
        <div class="flex flex-col items-center h-full lg:flex-row">
            <div class="flex flex-col items-center justify-center w-full h-full lg:w-2/3 lg:items-start">
                <p class="inline-block w-auto px-3 py-1 mb-5 text-xs font-medium text-white uppercase bg-green-400 rounded-full bg-gradient-to-br" data-primary="green-400">{{ $company->getConfig('loyalty_subtitle','') }}</p>
                <h1 class="font-extrabold tracking-tight text-center text-white lg:text-left xl:pr-32 text-6xl">{{ $company->getConfig('loyalty_heading','') }}</h1>
            </div>
            <div class="w-full max-w-sm mt-20 lg:mt-0 lg:w-1/3">
                <div class="relative">

                    @guest
                        <!-- Joint now box -->
                        <div class="relative z-10 h-auto p-8 pt-6 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7 opacity-90" data-rounded="rounded-lg" data-rounded-max="rounded-full">
                            <h3 class="mb-6 text-2xl font-light">{{ __('Join now') }}</h3>
                            <div class="relative block mb-4 font-light">
                                <p>
                                    {{ $company->getConfig('initial_loyalty_text1',__('loyalty.register_text1')) }}
                                </p>
                                <p class="mt-2">
                                    {{ $company->getConfig('initial_loyalty_text2',__('loyalty.register_text2')) }}
                                </p>
                            </div>
                        
                            <div class="block">
                                <button onclick="window.location.href='{{ route('register') }}'" class="w-full px-3 py-3 mt-2 font-medium text-white bg-green-400 rounded" data-rounded="rounded" data-primary="green-400">{{ __('loyalty.join_now')}}</button>
                            </div>
                        </div> 
                    @endguest

                    @auth
                        <!-- Card box -->
                        <div class="relative z-10 h-auto p-8 pt-6 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7 opacity-90" data-rounded="rounded-lg" data-rounded-max="rounded-full">
                            
                           

                            <h3 class="mb-6 text-2xl font-light">{{ auth()->user()->name }}</h3>
                            <div class="relative block mb-4 font-light">
                                @isset($card)
                                    <p>
                                        <span class="font-bold">{{ __('loyalty.points_on_card')}}:</span>
                                        <span class="text-bold">{{ $card->points }}</span>
                                        <br />
                                        <span class="mt-2 font-bold">{{ __('loyalty.card_id')}}:</span>
                                        <span class="text-bold">{{ $card->card_id }}</span>
                                    </p>
                                @endisset
                               
                            </div>
                        
                            <div class="block">
                                <button onclick="window.location.href='{{ route('home') }}'" class="w-full px-3 py-3 mt-2 font-medium text-white bg-green-400 rounded" data-rounded="rounded" data-primary="green-400">{{ __('Dashboard')}}</button>
                            </div>
                        </div>
                    @endauth
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>
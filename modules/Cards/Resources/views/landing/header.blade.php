<section class="w-full bg-white" data-tails-scripts="//unpkg.com/alpinejs"  x-data="{ showMenu: false }">

    <header class="relative block w-full py-6 leading-10 text-center">
        <div class="w-full px-6 mx-auto leading-10 text-center lg:px-8 max-w-7xl">
            <div class="box-border flex flex-wrap items-center justify-between -mx-4 text-indigo-900">
                <div class="relative z-10 flex items-center w-auto px-4 leading-10 lg:flex-grow-0 lg:flex-shrink-0 lg:text-left">
                    <a href="" class="box-border inline-block font-sans text-2xl font-bold text-left text-gray-900 no-underline bg-transparent cursor-pointer focus:no-underline">
                        <img class="w-1/5"  src="{{config('settings.logo')}}">
                    </a>
                </div>

                <div class="absolute left-0 z-10 justify-center hidden w-full px-4 -ml-5 space-x-4 font-medium leading-10 md:flex lg:-ml-0 lg:space-x-6 md:flex-grow-0 md:text-left lg:text-center" >
                    <a href="#features" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative inline-block px-0.5 text-lg font-medium text-gray-400 transition duration-150 ease hover:text-gray-800">
                        <span class="block">{{ __('Features')}}</span> 
                    </a>
                    @if ($isExtended)
                        <a href="#pricing" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative inline-block px-0.5 text-lg font-medium text-gray-400 transition duration-150 ease hover:text-gray-800">
                            <span class="block">{{ __('Pricing')}}</span>
                        </a>
                    @endif
                    
                    <a href="#faq" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative inline-block px-0.5 text-lg font-medium text-gray-400 transition duration-150 ease hover:text-gray-800">
                        <span class="block">{{ __('FAQ')}}</span>
                    </a>
                </div>
                @guest
                    <div class="z-10 relative items-center hidden px-4 mt-2 space-x-5 font-medium leading-10 md:flex md:flex-grow-0 md:flex-shrink-0 md:mt-0 md:text-right lg:flex-grow-0 lg:flex-shrink-0" :class="{'flex fixed top-0 left-0 w-full z-40': showMenu, 'hidden': !showMenu }">
                        <a href="{{ route('login') }}" class="bg-gray-100 text-gray-400 md:w-auto w-full px-8 py-3 rounded-full flex items-center justify-center font-medium text-lg focus:ring-offset-2 focus:ring-2 focus:ring-gray-100 focus:text-gray-700 hover:text-gray-700">{{ __('Login') }}</a>
                        <a href="{{ route('newcompany.register')  }}" class="bg-yellow-300 text-white md:w-auto w-full px-8 py-3 rounded-full flex items-center justify-center font-medium text-lg focus:ring-offset-2 focus:ring-2 focus:ring-yellow-300">{{ __('Signup') }}</a>
                    </div>
                @endguest

                @auth
                    <div class="z-10 relative items-center hidden px-4 mt-2 space-x-5 font-medium leading-10 md:flex md:flex-grow-0 md:flex-shrink-0 md:mt-0 md:text-right lg:flex-grow-0 lg:flex-shrink-0" :class="{'flex fixed top-0 left-0 w-full z-40': showMenu, 'hidden': !showMenu }">
                        <a href="{{ route('home') }}" class="bg-yellow-300 text-white md:w-auto w-full px-8 py-3 rounded-full flex items-center justify-center font-medium text-lg focus:ring-offset-2 focus:ring-2 focus:ring-yellow-300">{{ __('Dashboard') }}</a>
                    </div>
                @endauth

                <!-- Mobile Nav  -->
                <nav class="fixed top-0 right-0 z-10 flex w-10 h-10 mt-4 mr-4 md:hidden">
                    <button @click="showMenu = !showMenu" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-white hover:bg-opacity-25 focus:outline-none">
                        <svg class="w-5 h-5 text-gray-800 fill-current" x-show="!showMenu" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg>
                        <svg class="w-5 h-5 text-gray-500" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </nav>
                <!-- End Mobile Nav -->
                

               
            </div>
        </div>
    </header>

    <main class="w-full relative">
        <div class="max-w-7xl px-10 mx-auto flex lg:flex-row flex-col py-10">
            <div class="w-full lg:w-1/2 flex lg:justify-start justify-start md:justify-center">
                <div class="lg:py-24 lg:text-left text-left md:text-center">
                    <h1 class="mt-4 text-4xl tracking-tight font-extrabold text-gray-800 sm:mt-5 lg:text-left text-left md:text-center sm:text-6xl lg:mt-6 xl:text-7xl">
                        <span class="block">{{ __('loyalty.title') }}</span>
                        <span class="block text-yellow-300 flex items-center justify-start lg:justify-start md:justify-center w-full"> {{ __('loyalty.subtitle') }} </span>
                    </h1>
                    <p class="mt-3 text-base text-gray-400 sm:mt-5 sm:text-xl lg:text-lg lg:text-left text-left md:text-center xl:text-xl">
                        {{ __('loyalty.intro') }}
                    </p>
                    <div class="mt-6 sm:mt-8">
                        <div class="flex md:flex-row flex-col md:space-x-5 md:space-y-0 space-y-5 lg:justify-start justify-center">
                            <a href="{{ route('newcompany.register') }}" class="bg-yellow-300 text-white md:w-auto w-full px-8 py-4 rounded-full flex items-center justify-center font-medium text-lg focus:ring-offset-2 focus:ring-2 focus:ring-yellow-300">{{__('loyalty.sign_up_now') }}</a>
                            <a  href="{{ __('loyalty.video_link')}}" class=" bg-gray-800 text-white px-8 py-4 rounded-full flex items-center justify-center font-medium text-lg focus:ring-offset-2 focus:ring-2 focus:ring-gray-800"">
                                <span class="-ml-2 mr-3"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg></span>
                                <span class="">{{ __('loyalty.see_how_it_works')}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 flex lg:justify-center lg:max-w-none max-w-md lg:mt-0 mt-20 mx-auto relative">
                <div class="w-auto sm:w-64 absolute bottom-0 transform md:bottom-auto md:top-1/2 p-8 translate-y-16 md:translate-y-24 md:ml-16 z-10 left-0 bg-white text-gray-400 rounded-xl shadow-2xl">
                    <div class="inline-flex absolute top-0 transform -translate-y-full bg-yellow-300 left-0 space-x-1 px-4 items-center h-9 w-auto rounded-full -mt-2">

                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 534 509" xmlns="http://www.w3.org/2000/svg"><path d="m409.8 313.24 114.8-94.637c16.238-13.441 7.84-39.762-13.441-40.879l-147.84-8.96c-8.96-.56-16.801-6.161-20.16-14.56l-54.32-138.88c-7.84-19.602-35.281-19.602-43.121 0l-54.32 138.32c-3.36 8.399-11.199 14-20.16 14.56l-148.4 8.96c-21.281 1.121-29.68 27.441-13.441 40.879l114.8 94.078c6.719 5.602 10.078 15.121 7.84 23.52l-37.52 143.92c-5.04 20.16 16.8 36.398 34.719 25.199l124.88-80.078c7.84-5.04 17.359-5.04 24.64 0l125.44 80.078c17.923 11.199 39.763-5.04 34.72-25.199l-37.52-143.36c-1.68-8.398 1.12-17.359 8.402-22.961h.002Z" fill-rule="nonzero"></path></svg>
                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 534 509" xmlns="http://www.w3.org/2000/svg"><path d="m409.8 313.24 114.8-94.637c16.238-13.441 7.84-39.762-13.441-40.879l-147.84-8.96c-8.96-.56-16.801-6.161-20.16-14.56l-54.32-138.88c-7.84-19.602-35.281-19.602-43.121 0l-54.32 138.32c-3.36 8.399-11.199 14-20.16 14.56l-148.4 8.96c-21.281 1.121-29.68 27.441-13.441 40.879l114.8 94.078c6.719 5.602 10.078 15.121 7.84 23.52l-37.52 143.92c-5.04 20.16 16.8 36.398 34.719 25.199l124.88-80.078c7.84-5.04 17.359-5.04 24.64 0l125.44 80.078c17.923 11.199 39.763-5.04 34.72-25.199l-37.52-143.36c-1.68-8.398 1.12-17.359 8.402-22.961h.002Z" fill-rule="nonzero" class=""></path></svg>
                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 534 509" xmlns="http://www.w3.org/2000/svg"><path d="m409.8 313.24 114.8-94.637c16.238-13.441 7.84-39.762-13.441-40.879l-147.84-8.96c-8.96-.56-16.801-6.161-20.16-14.56l-54.32-138.88c-7.84-19.602-35.281-19.602-43.121 0l-54.32 138.32c-3.36 8.399-11.199 14-20.16 14.56l-148.4 8.96c-21.281 1.121-29.68 27.441-13.441 40.879l114.8 94.078c6.719 5.602 10.078 15.121 7.84 23.52l-37.52 143.92c-5.04 20.16 16.8 36.398 34.719 25.199l124.88-80.078c7.84-5.04 17.359-5.04 24.64 0l125.44 80.078c17.923 11.199 39.763-5.04 34.72-25.199l-37.52-143.36c-1.68-8.398 1.12-17.359 8.402-22.961h.002Z" fill-rule="nonzero" class=""></path></svg>
                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 534 509" xmlns="http://www.w3.org/2000/svg"><path d="m409.8 313.24 114.8-94.637c16.238-13.441 7.84-39.762-13.441-40.879l-147.84-8.96c-8.96-.56-16.801-6.161-20.16-14.56l-54.32-138.88c-7.84-19.602-35.281-19.602-43.121 0l-54.32 138.32c-3.36 8.399-11.199 14-20.16 14.56l-148.4 8.96c-21.281 1.121-29.68 27.441-13.441 40.879l114.8 94.078c6.719 5.602 10.078 15.121 7.84 23.52l-37.52 143.92c-5.04 20.16 16.8 36.398 34.719 25.199l124.88-80.078c7.84-5.04 17.359-5.04 24.64 0l125.44 80.078c17.923 11.199 39.763-5.04 34.72-25.199l-37.52-143.36c-1.68-8.398 1.12-17.359 8.402-22.961h.002Z" fill-rule="nonzero" class=""></path></svg>
                        <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 534 509" xmlns="http://www.w3.org/2000/svg"><path d="m409.8 313.24 114.8-94.637c16.238-13.441 7.84-39.762-13.441-40.879l-147.84-8.96c-8.96-.56-16.801-6.161-20.16-14.56l-54.32-138.88c-7.84-19.602-35.281-19.602-43.121 0l-54.32 138.32c-3.36 8.399-11.199 14-20.16 14.56l-148.4 8.96c-21.281 1.121-29.68 27.441-13.441 40.879l114.8 94.078c6.719 5.602 10.078 15.121 7.84 23.52l-37.52 143.92c-5.04 20.16 16.8 36.398 34.719 25.199l124.88-80.078c7.84-5.04 17.359-5.04 24.64 0l125.44 80.078c17.923 11.199 39.763-5.04 34.72-25.199l-37.52-143.36c-1.68-8.398 1.12-17.359 8.402-22.961h.002Z" fill-rule="nonzero" class=""></path></svg>
                    </div>
                    <p class="text-gray-800 font-bold">{{ __('loyalty.demo_user')}}<br><span style="color: rgb(156, 163, 175); font-weight: 400;" class=""><b class="">#{{ __('loyalty.demo_card_id') }}</b></span><br></p>
                    <p class="mt-2"></p><div class=""><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); color: rgb(156 163 175 / var(--tw-text-opacity)); font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;" class="">{{ __('loyalty.demo_points')}}</span><br></div><div class="tails-relative">{{ __('loyalty.demo_value')}}</div><div class=""></div><p></p>
                </div>
                <div class="w-full flex items-end max-w-md h-auto relative">
                    <div class="h-2/3 bg-blue-100 absolute transform left-0 bottom-0 w-full md:ml-5 overflow-hidden rounded-2xl">
                        <div class="rounded-full transform bg-blue-500 w-48 h-48 right-0 absolute top-1/2 -translate-y-1/2 -mr-32"></div>
                        <div class="rounded-full transform bg-yellow-300 w-32 h-32 right-0 absolute top-0 -translate-y-1/2 -mr-12 -mt-2"></div>
                        <div class="rounded-full transform bg-yellow-300 w-32 h-32 left-0 absolute bottom-0 translate-y-1/2 -ml-12"></div>
                    </div>

                    <img src="{{ asset('uploads') }}/default/loyalty/hero.png" class="relative">
                </div>
            </div>
        </div>
        @if (count($showcase)>0)
            <svg  class="w-full absolute sm:block hidden fill-current text-gray-800 bottom-0 left-0 -mb-1" viewBox="0 0 1370 65" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0c243.727 42.976 472.06 64.464 685 64.464S1126.273 42.976 1370 0v64.464H0V0z" fill-rule="evenodd" class=""></path>
            </svg> 
        @endif
       
    </main>


    <!-- Logos -->
    @if (count($showcase)>0)
        <div class=" bg-gray-800 sm:mt-0 mt-20">
            <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                    @foreach ($showcase as $case)
                        <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                           <a href="{{ $case->link }}"> <img src="{{ $case->image_link }}" class="h-8"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</section>
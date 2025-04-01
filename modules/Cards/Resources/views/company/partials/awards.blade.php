<section class="relative w-full bg-white" >
    <div class="absolute w-full h-32 bg-gradient-to-b from-gray-100 to-white"></div>
    <div class="relative w-full px-5 py-10 mx-auto sm:py-12 md:py-16 md:px-10 max-w-7xl">

        <h1 class="mb-1 text-4xl font-extrabold leading-none text-gray-900 lg:text-5xl xl:text-6xl sm:mb-3"><a href="#_" class="">{{ __('How to use your points') }}</a></h1>
        <p class="text-lg font-medium text-gray-500 sm:text-2xl">{{ __('Turn your points into awards or discount coupons') }}</p>
        <div class="flex grid h-full grid-cols-12 gap-10 pb-10 mt-8 sm:mt-16">

            @foreach ($rewards as $reward)
            <div class="relative flex flex-col items-start justify-end h-full col-span-12 overflow-hidden rounded-xl group md:col-span-6 xl:col-span-4" style="max-height: 540px; min-height: 550px">
                <a href="#_" class="block w-full transition duration-300 ease-in-out transform bg-center bg-cover h-96 hover:scale-110" style="background-image:url('{{ $reward->image_link }}')">
                </a>
                <div class="relative z-20 w-full h-auto py-8 text-white border-t-0 border-yellow-200 px-7" style="background-color: {{ $reward->color }}">
                    <a href="#_" class="inline-block text-xs font-semibold absolute top-0 -mt-3.5 rounded-full px-4 py-2 uppercase text-purple-500 bg-white">{{ $reward->points }} {{ __('points')}}</a>
                    <h2 class="mb-5 text-5xl font-bold"><a href="#_" class="">{{ $reward->title }}</a></h2>
                    <p class="mb-2 text-lg font-normal text-purple-100 opacity-100">{{ $reward->description }}</p>
                    
                    @guest
                        <a href="{{ route('login') }}" class="mt-3 relative block w-full py-4 overflow-hidden text-base font-semibold text-center text-gray-800 bg-white rounded-lg" data-rounded="rounded-lg">
                            <span>{{ __('loyalty.get_it') }}</span>
                        </a> 
                    @endguest
                    @auth
                        @if (isset($card)&&$card->points>=$reward->points)
                            <a 
                            onclick="return confirm('{{ __('loyalty.confirm_exchange') }}')"
                            href="{{ route('loyalty.exchange',['reward'=>$reward->id]) }}" class="mt-3 relative block w-full py-4 overflow-hidden text-base font-semibold text-center text-gray-800 bg-white rounded-lg" data-rounded="rounded-lg">
                                <span>{{ __('loyalty.get_it') }}</span>
                            </a> 
                        @else
                            <a href="#" class="mt-3 relative block w-full py-4 overflow-hidden text-base font-semibold text-center text-gray-800 bg-white rounded-lg opacity-50" data-rounded="rounded-lg">
                                <span>{{ __('loyalty.not_enought_points') }}</span>
                            </a> 
                        @endif
                        
                    @endauth
                    
                </div>
            </div>
 
            @endforeach
            

        </div>
    </div>
</section>
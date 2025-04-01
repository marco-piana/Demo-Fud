<section id="pricing" class="py-12 bg-gray-800 md:py-20 bg-gradient-to-b from-gray-800 to-black">

    <div class="max-w-4xl px-10 mx-auto text-left md:text-center pb-14 md:px-0">
      <h2 class="text-4xl font-bold text-white md:text-5xl">{{ __('Simple, Transparent Pricing.') }}</h2>
      <p class="mt-2 text-lg text-gray-400">{{ __('Simple pricing to fit your needs. Pricing for companies of any size.') }}</p></div>

    <div class="flex flex-col max-w-4xl mx-auto divide-x-0 divide-gray-800 md:divide-x lg:divide-x-0 md:flex-row lg:space-x-8">

       @foreach ($plans as $plan )
           <!-- Show single plan -->
           <div class="w-full md:w-1/2">
            <div class="relative w-full p-10 overflow-hidden bg-gray-900 shadow-xl lg:rounded-lg" data-rounded="rounded-lg" data-rounded-max="rounded-full">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-500 to-red-500" data-primary="red-500"></div>
                <div class="flex items-center justify-between text-gray-200">

                    <div class="relative justif-self-end">
                        <h2 class="text-2xl font-black text-white">{{ __($plan['name'])}}</h2>
                        <p class="text-xs font-medium uppercase">{{ __('Plan')}}</p>
                    </div>
                    <div class="flex items-center">
                        <h3 class="text-5xl text-white">{{ $plan['price_form'] }}</h3>
                        <div class="flex flex-col ml-3">
                            <p class="font-medium">{{__('per')}} {{  $plan['period'] == 1? __('month') :  __('year') }}</p>
                            <p class="text-sm">{{ __($plan['description'])}}</p>

                        </div>
                    </div>

                </div>
                <div class="border-t border-gray-700 h-0.5 my-10 w-full"></div>
                <ul class="w-full py-2 my-12 space-y-5 text-xl text-gray-300">
                    @foreach (explode(",",$plan['features']) as $feature)
                        <li class="flex items-center">
                            <div class="flex items-center justify-center w-8 h-8 mr-3 text-white bg-gray-700 rounded-full">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span>{{ __($feature) }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('newcompany.register')}}" class="relative block w-full py-4 overflow-hidden text-base font-semibold text-center text-gray-800 bg-white rounded-lg" data-rounded="rounded-lg">
                    <span>{{ __('Get Started') }}</span>
                </a>
            </div>
        </div>
       @endforeach

        

    </div>

</section>
@if (count($featured_vendors) > 0)
<section class="w-full py-12  bg-gray-800 md:py-20 bg-gradient-to-b from-gray-800 to-black lg:py-24">
    <div class="max-w-6xl  mx-auto text-center">
        <div class="text-left">
            <div class="mb-10 sm:mx-auto">
                <h3 class="relative text-3xl font-bold tracking-tight sm:text-4xl  text-white">{{ __('Demo loyalty programs')}}</h3>
               
            </div>
        </div>

        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featured_vendors as $vendor)
                <a href="{{$vendor->getLinkAttribute()}}" target="_blank">
                    <div class="relative w-full rounded-lg shadow-sm  overflow-hidden bg-gray-900">
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-500 to-red-500" data-primary="red-500"></div>
                        <div class="flex flex-col items-center justify-center p-10">
                        
                                <img class="w-50 h-50 mb-6" src="{{ $vendor->logom }}">
                                <h2 class="text-lg font-medium  text-white">{{ $vendor->name }}</h2>
                                <p class="text-gray-400">{{$vendor->description}}</p>
                            
                        </div>
                    </div>
                </a>
                       
            @endforeach
        </div>

    </div>
</section>
@endif

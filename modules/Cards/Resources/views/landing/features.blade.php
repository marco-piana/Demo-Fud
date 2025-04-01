<section id="features" class="w-full px-10 bg-gray-50 lg:px-0" >
    <div class="py-20 mx-auto max-w-7xl">
        <h2 class="flex justify-start w-full text-4xl font-black text-left md:text-5xl md:text-center md:justify-center">
            <span class="">{{ __('Features')}}</span>
        </h2>
        <div class="grid gap-10 pt-16 pb-10 md:grid-cols-2">
            @foreach ($features as $feature)
                <!-- Single feature -->
                <div class="relative p-10 space-y-2 border border-gray-200 rounded-lg">
                    <img class="w-2/12" src="
                        @if ($feature->image_link)
                            {{ $feature->image_link }}
                        @endif" />
                    <h3 class="text-2xl font-black">{{ $feature->title }}</h3>
                    <p class="text-gray-700">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

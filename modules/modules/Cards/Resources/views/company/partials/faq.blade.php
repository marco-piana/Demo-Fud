<section class="py-24 bg-gray-900" data-tails-scripts="//unpkg.com/alpinejs"  >
    <div class="px-8 mx-auto lg:px-16 max-w-7xl" id="faq">
        <h2 class="mb-2 text-xl font-bold text-white md:text-3xl">{{ __('Frequently Asked Questions') }}</h2>

        <div class="relative mt-2 mt-8">

            @foreach ($faqs as $faq)
                <!-- Question -->
            <div x-data="{ show: false }" class="relative overflow-hidden text-white select-none">
                <h4 @click="show=!show" class="flex items-center justify-between py-5 text-lg font-medium text-gray-100 cursor-pointer sm:text-xl hover:text-white">
                    <span class="">{{ $faq->title}}</span>
                    <svg class="w-6 h-6 text-yellow-400 transition-all duration-200 ease-out transform rotate-0 fill-current -rotate-45" data-primary="yellow-500" :class="{ '-rotate-45' : show }" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" class=""></path></svg>
                </h4>
                <p class="px-1 pt-0 mt-1 text-gray-300 sm:text-lg py-7" x-transition:enter="transition-all ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform -translate-y-0" x-transition:leave="transition-all ease-out hidden duration-200" x-transition:leave-start="opacity-100 transform -translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4" x-show="show">{{ $faq->description}}</p>
            </div>
            @endforeach
        


        </div>

    </div>
</section>
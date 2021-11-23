<x-app-layout>
    <x-hero></x-hero>
    <section class="container px-5 py-12 mx-auto">
        <div class="mb-12">
            <div class="flex-justify-center">
                @foreach ($tags as $tag)
                    <a 
                        href="{{ route('listings.index', ['tag' => $tag->slug]) }}&{{ http_build_query(request()->except('tag', 'page')) }}"
                        class="inline-block ml-2 tracking-wide text-xs font-medium py-0.5 px-1.5 border border-indigo-500 uppercase {{ $tag->slug == request()->get('tag') ? 'bg-indigo-500 text-white' : '' }}"
                    >{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="mb-12">
            <h2 class="px-4 text-2xl font-medium text-gray-900">All Jobs ({{ $listings->count() }})</h2>
        </div>
        <div class="-my-6">
            @foreach ($listings as $listing)
                <a 
                    href=""
                    class="flex flex-wrap px-4 py-6 border-b border-gray-100 md:flex-nowrap {{ $listing->is_highlighted ? 'bg-yellow-100 hover:bg-yellow-200' : 'bg-white hover:bg-gray-100' }}"
                >
                    <div class="flex flex-col flex-shrink-0 mb-6 mr-4 md:w-16 md:mb-0">
                        <img src="/storage/{{ $listing->logo }}" alt="{{ $listing->company }}"
                            class="object-cover w-16 h-16 rounded-full"
                        >
                    </div>
                    <div class="flex flex-col items-start justify-center mr-8 md:w-1/2">
                        <h2 class="mb-1 text-xl font-bold text-gray-900 title-font">
                            {{ $listing->title }}
                        </h2>
                        <p class="leading-relaxed text-gray-900">
                            {{ $listing->company }} &mdash; <span class="text-gray-600">{{ $listing->location }}</span>
                        </p>
                    </div>
                    <div class="flex items-center justify-start mr-8 md:flex-grow">
                        @foreach ($listing->tags as $tag)
                            <span class="inline-block ml-2 tracking-wide text-xs font-medium py-0.5 px-1.5 border border-indigo-500 uppercase">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <span class="flex items-center justify-end mr-8 md:flex-grow">
                        <span>{{ $listing->created_at->diffForHumans() }}</span>
                    </span>
                </a>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $listings->links() }}
        </div>
    </section>
</x-app-layout>
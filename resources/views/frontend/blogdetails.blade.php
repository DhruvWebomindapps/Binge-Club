<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/blog-single.css') }}">
    @endpush
    <section class="py-5">
        <div class="container">
            <div class="blog-detail">
                <!--  -->
                <div class="blog-back-btn">
                    <a href="{{ url()->previous() }}">
                        <i class="far fa-chevron-left">
                            <span class="page-back-text">Back to Blogs</span>
                        </i>
                    </a>
                </div>
                <img src="{{ asset('storage/' . $blog->image) }}" class="w-100" style="object-fit:cover;">
                <!--  -->
                <h1 class="blog-heading">{{ $blog->title }}</h1>

                <!-- blog author -->
                <div class="blog-card-author-detail">
                    <div>
                        <span class="blog-publish-date"><i class="fal fa-calendar-minus"></i></span>
                        {{ $blog->created_at->format('d F, Y') }}
                    </div>
                    {{-- 10 May, 2020 --}}
                </div>
                <!--  -->

                <p class="my-4">
                    {{ $blog->description }}
                </p>
            </div>
        </div>
    </section>
</x-home-layout>

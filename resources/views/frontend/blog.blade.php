<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/blog.css') }}">
    @endpush
    <!-- Blog -->
    <section class="blog-sec pt-5 pb-5 bg-theme">
        <div class="container">
            <div class="row pt-4">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 blog-card">
                        <a href="{{ route('blog.details', $blog->slug) }}">
                            <!-- blog image -->
                            <div class="blog-card-images z-depth-2">
                                <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid" alt="">
                            </div>
                            <!--  -->

                            <!-- bookmark -->

                            <div class="bookmark">
                                <input type="checkbox" id="bookmark1" />
                                <label for="bookmark1"></label>
                            </div>

                            <!-- blog title -->
                            <div class="blog-card-title">
                                <h2>{{ $blog->title }}</h2>
                            </div>
                            <!--  -->

                            <!-- blog author -->
                            <div class="blog-card-author-detail">
                                <div>
                                    <span class="blog-publish-date">
                                        <i class="fal fa-calendar-minus"></i>
                                        {{ $blog->created_at->format('d F, Y') }}
                                    </span>
                                </div>
                            </div>
                            <!--  -->

                            <!-- blog description -->
                            <div class="blog-card-description">
                                <p>{{ Str::words($blog->description, 20, '...') }}</p>
                            </div>
                            <!--  -->
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-home-layout>

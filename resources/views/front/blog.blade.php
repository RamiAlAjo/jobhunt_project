@extends('front.layout.app')

@section('seo_title'){{ $blog_page_item->title }}@endsection
@section('seo_meta_description'){{ $blog_page_item->meta_description }}@endsection

@section('main_content')
<!-- 
    Purpose: This section represents the main content of the blog page. 
    It includes a top banner with a background image, displays a list of blog posts, 
    and provides pagination for navigating through multiple pages of posts.
-->

<div class="page-top" style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_blog) }}')">
    <!-- Top Banner Section with Background Image -->
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $blog_page_item->heading }}</h2>
                <!-- Displaying the heading of the blog page dynamically -->
            </div>
        </div>
    </div>
</div>

<div class="blog">
    <div class="container">
        <div class="row">

            <!-- Looping through each blog post -->
            @foreach($posts as $item)
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <div class="photo">
                        <img src="{{ asset('uploads/'.$item->photo) }}" alt="" />
                        <!-- Displaying the featured image of the blog post -->
                    </div>
                    <div class="text">
                        <h2>
                            <a href="{{ route('post', $item->slug) }}">
                                {{ $item->title }}
                                <!-- Linking the title to the individual blog post page -->
                            </a>
                        </h2>
                        <div class="short-des">
                            <p>
                                {!! nl2br($item->short_description) !!}
                                <!-- Displaying a short description of the post, converting new lines to <br> tags -->
                            </p>
                        </div>
                        <div class="button">
                            <a href="{{ route('post', $item->slug) }}" class="btn btn-primary">
                                Read More
                                <!-- Button linking to the full blog post -->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-md-12">
                {{ $posts->links() }}
                <!-- Pagination links for navigating through the blog posts -->
            </div>

        </div>
    </div>
</div>

@endsection
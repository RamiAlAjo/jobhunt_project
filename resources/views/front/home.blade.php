@extends('front.layout.app')

@section('seo_title'){{ $home_page_data->title }}@endsection
@section('seo_meta_description'){{ $home_page_data->meta_description }}@endsection

@section('main_content')

<!-- Slider Section -->
<div class="slider" style="background-image: url({{ asset('uploads/'.$home_page_data->background) }})">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="item">
                    <div class="text">
                        <!-- Heading and Description from Home Page Data -->
                        <h2>{{ $home_page_data->heading }}</h2>
                        <p>{!! $home_page_data->text !!}</p>
                    </div>
                    <div class="search-section">
                        <!-- Job Search Form -->
                        <form action="{{ url('job-listing') }}" method="get">
                            <div class="inner">
                                <div class="row">
                                    <!-- Job Title Search Input -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control"
                                                placeholder="{{ $home_page_data->job_title }}">
                                        </div>
                                    </div>
                                    <!-- Job Category Dropdown -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="category" class="form-select select2">
                                                <option value="">{{ $home_page_data->job_category }}</option>
                                                @foreach($all_job_categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Job Location Dropdown -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="location" class="form-select select2">
                                                <option value="">{{ $home_page_data->job_location }}</option>
                                                @foreach($all_job_locations as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Hidden Fields for Additional Filters -->
                                    <div class="col-lg-3">
                                        <input type="hidden" name="type" value="">
                                        <input type="hidden" name="experience" value="">
                                        <input type="hidden" name="gender" value="">
                                        <input type="hidden" name="salary_range" value="">
                                        <!-- Search Button -->
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> {{ $home_page_data->search }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Category Section: Display Categories if Status is 'Show' -->
@if($home_page_data->job_category_status == 'Show')
<div class="job-category">
    <div class="container">
        <!-- Section Heading -->
        <div class="heading">
            <h2>{{ $home_page_data->job_category_heading }}</h2>
            <p>{{ $home_page_data->job_category_subheading }}</p>
        </div>
        <div class="row">
            <!-- Loop through job categories and display each one -->
            @foreach($job_categories as $item)
            <div class="col-md-4">
                <div class="item">
                    <div class="icon"><i class="{{ $item->icon }}"></i></div>
                    <h3>{{ $item->name }}</h3>
                    <p>({{ $item->r_job_count }} Open Positions)</p>
                    <!-- Link to Filter Jobs by Category -->
                    <a href="{{ url('job-listing?category='.$item->id) }}"></a>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Button to View All Categories -->
        <div class="all">
            <a href="{{ route('job_categories') }}" class="btn btn-primary">See All Categories</a>
        </div>
    </div>
</div>
@endif

<!-- Why Choose Section: Display Why Choose Items if Status is 'Show' -->
@if($home_page_data->why_choose_status == 'Show')
<div class="why-choose" style="background-image: url({{ asset('uploads/'.$home_page_data->why_choose_background) }})">
    <div class="container">
        <!-- Section Heading -->
        <div class="heading">
            <h2>{{ $home_page_data->why_choose_heading }}</h2>
            <p>{{ $home_page_data->why_choose_subheading }}</p>
        </div>
        <div class="row">
            <!-- Loop through "Why Choose" items and display each one -->
            @foreach($why_choose_items as $item)
            <div class="col-md-4">
                <div class="inner">
                    <div class="icon"><i class="{{ $item->icon }}"></i></div>
                    <div class="text">
                        <h2>{{ $item->heading }}</h2>
                        <p>{!! nl2br($item->text) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Featured Jobs Section: Display Featured Jobs if Status is 'Show' -->
@if($home_page_data->featured_jobs_status == 'Show')
<div class="job">
    <div class="container">
        <!-- Section Heading -->
        <div class="heading">
            <h2>{{ $home_page_data->featured_jobs_heading }}</h2>
            <p>{{ $home_page_data->featured_jobs_subheading }}</p>
        </div>
        <div class="row">
            <!-- Loop through featured jobs and display each one -->
            @foreach($featured_jobs as $item)
            @php
            $order_data = \App\Models\Order::where('company_id', $item->rCompany->id)
            ->where('currently_active', 1)
            ->first();
            if (!$order_data || date('Y-m-d') > $order_data->expire_date) {
            continue;
            }
            @endphp
            <div class="col-lg-6 col-md-12">
                <div class="item d-flex justify-content-start">
                    <div class="logo"><img src="{{ asset('uploads/'.$item->rCompany->logo) }}" alt=""></div>
                    <div class="text">
                        <h3><a href="{{ route('job', $item->id) }}">{{ $item->title }},
                                {{ $item->rCompany->company_name }}</a></h3>
                        <div class="detail-1 d-flex justify-content-start">
                            <div class="category">{{ $item->rJobCategory->name }}</div>
                            <div class="location">{{ $item->rJobLocation->name }}</div>
                        </div>
                        <div class="detail-2 d-flex justify-content-start">
                            <div class="date">{{ $item->created_at->diffForHumans() }}</div>
                            <div class="budget">{{ $item->rJobSalaryRange->name }}</div>
                            @if(date('Y-m-d') > $item->deadline)
                            <div class="expired">Expired</div>
                            @endif
                        </div>
                        <div class="special d-flex justify-content-start">
                            @if($item->is_featured == 1)<div class="featured">Featured</div>@endif
                            <div class="type">{{ $item->rJobType->name }}</div>
                            @if($item->is_urgent == 1)<div class="urgent">Urgent</div>@endif
                        </div>
                        <!-- Bookmarking Feature for Non-Company Users -->
                        @if(!Auth::guard('company')->check())
                        <div class="bookmark">
                            @php $bookmark_status = Auth::guard('candidate')->check() &&
                            \App\Models\CandidateBookmark::where('candidate_id',
                            Auth::guard('candidate')->user()->id)->where('job_id', $item->id)->exists() ? 'active' : '';
                            @endphp
                            <a href="{{ route('candidate_bookmark_add', $item->id) }}"><i
                                    class="fas fa-bookmark {{ $bookmark_status }}"></i></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="all">
            <a href="{{ route('job_listing') }}" class="btn btn-primary">See All Jobs</a>
        </div>
    </div>
</div>
@endif

<!-- Testimonials Section: Display Testimonials if Status is 'Show' -->
@if($home_page_data->testimonial_status == 'Show')
<div class="testimonial" style="background-image: url({{ asset('uploads/'.$home_page_data->testimonial_background) }})">
    <div class="bg"></div>
    <div class="container">
        <h2 class="main-header">{{ $home_page_data->testimonial_heading }}</h2>
        <div class="testimonial-carousel owl-carousel">
            <!-- Loop through testimonials and display each one -->
            @foreach($testimonials as $item)
            <div class="item">
                <div class="photo"><img src="{{ asset('uploads/'.$item->photo) }}" alt="" /></div>
                <div class="text">
                    <h4>{{ $item->name }}</h4>
                    <p>{{ $item->designation }}</p>
                </div>
                <div class="description">
                    <p>{!! nl2br($item->comment) !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Blog Section: Display Blogs if Status is 'Show' -->
@if($home_page_data->blog_status == 'Show')
<div class="blog">
    <div class="container">
        <div class="heading">
            <h2>{{ $home_page_data->blog_heading }}</h2>
            <p>{{ $home_page_data->blog_subheading }}</p>
        </div>
        <div class="row">
            <!-- Loop through blog posts and display each one -->
            @foreach($posts as $item)
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <div class="photo"><img src="{{ asset('uploads/'.$item->photo) }}" alt="" /></div>
                    <div class="text">
                        <h2><a href="{{ route('post', $item->slug) }}">{{ $item->title }}</a></h2>
                        <div class="short-des">
                            <p>{!! nl2br($item->short_description) !!}</p>
                        </div>
                        <div class="button">
                            <a href="{{ route('post', $item->slug) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
@extends('front.layout.app')

@section('seo_title'){{ $job_category_page_item->title }}@endsection
@section('seo_meta_description'){{ $job_category_page_item->meta_description }}@endsection

@section('main_content')

<!-- Page Top Section with Banner Image -->
<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_job_categories) }}')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Heading (Title) -->
                <h2>{{ $job_category_page_item->heading }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Job Category Listings Section -->
<div class="job-category">
    <div class="container">
        <div class="row">
            <!-- Looping through all job categories and displaying each one -->
            @foreach($job_categories as $item)
            <div class="col-md-4">
                <div class="item">
                    <!-- Category Icon -->
                    <div class="icon">
                        <!-- Displaying the icon of the job category (using FontAwesome or custom icon) -->
                        <i class="{{ $item->icon }}"></i>
                    </div>
                    <!-- Category Name -->
                    <h3>{{ $item->name }}</h3>
                    <!-- Open Positions for the current job category -->
                    <p>({{ $item->r_job_count }} Open Positions)</p>
                    <!-- Link to filter jobs by this category -->
                    <a href="{{ url('job-listing?category='.$item->id) }}"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
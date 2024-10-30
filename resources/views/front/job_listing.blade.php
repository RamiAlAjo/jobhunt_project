@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->job_listing_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->job_listing_page_meta_description }}@endsection

@section('main_content')
<!-- Page Top Section with Banner -->
<div class="page-top" style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_job_listing) }}')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Heading -->
                <h2>{{ $other_page_item->job_listing_page_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Job Listing Results Section -->
<div class="job-result">
    <div class="container">
        <div class="row">
            <!-- Sidebar for Filters -->
            <div class="col-md-3">
                <div class="job-filter">
                    <!-- Job Search Filter Form -->
                    <form action="{{ url('job-listing') }}" method="get">
                        <!-- Job Title Filter -->
                        <div class="widget">
                            <h2>Job Title</h2>
                            <input type="text" name="title" class="form-control" placeholder="Search Titles ..."
                                value="{{ $form_title }}">
                        </div>

                        <!-- Job Category Filter -->
                        <div class="widget">
                            <h2>Job Category</h2>
                            <select name="category" class="form-control select2">
                                <option value="">Job Category</option>
                                @foreach($job_categories as $item)
                                <option value="{{ $item->id }}" @if($form_category==$item->id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Job Location Filter -->
                        <div class="widget">
                            <h2>Job Location</h2>
                            <select name="location" class="form-control select2">
                                <option value="">Job Location</option>
                                @foreach($job_locations as $item)
                                <option value="{{ $item->id }}" @if($form_location==$item->id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Job Type Filter -->
                        <div class="widget">
                            <h2>Job Type</h2>
                            <select name="type" class="form-control select2">
                                <option value="">Job Type</option>
                                @foreach($job_types as $item)
                                <option value="{{ $item->id }}" @if($form_type==$item->id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Job Experience Filter -->
                        <div class="widget">
                            <h2>Job Experience</h2>
                            <select name="experience" class="form-control select2">
                                <option value="">Job Experience</option>
                                @foreach($job_experiences as $item)
                                <option value="{{ $item->id }}" @if($form_experience==$item->id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Job Gender Filter -->
                        <div class="widget">
                            <h2>Job Gender</h2>
                            <select name="gender" class="form-control select2">
                                <option value="">Job Gender</option>
                                @foreach($job_genders as $item)
                                <option value="{{ $item->id }}" @if($form_gender==$item->id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Job Salary Range Filter -->
                        <div class="widget">
                            <h2>Job Salary Range</h2>
                            <select name="salary_range" class="form-control select2">
                                <option value="">Job Salary Range</option>
                                @foreach($job_salary_ranges as $item)
                                <option value="{{ $item->id }}" @if($form_salary_range==$item->id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="filter-button">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </form>

                    <!-- Advertisement Section, if enabled -->
                    @if($advertisement_data->job_listing_ad_status == 'Show')
                    <div class="advertisement">
                        <!-- Displaying the advertisement, either as an image or as a clickable link -->
                        @if($advertisement_data->job_listing_ad_url == null)
                        <img src="{{ asset('uploads/'.$advertisement_data->job_listing_ad) }}" alt="">
                        @else
                        <a href="{{ $advertisement_data->job_listing_ad_url }}" target="_blank"><img
                                src="{{ asset('uploads/'.$advertisement_data->job_listing_ad) }}" alt=""></a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Job Listings Display Section -->
            <div class="col-md-9">
                <div class="job">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Search Result Header -->
                                <div class="search-result-header">
                                    <i class="fas fa-search"></i> Search
                                    Result for Job Listing
                                </div>
                            </div>

                            <!-- Displaying "No Result Found" if no jobs are available -->
                            @if(!$jobs->count())
                            <div class="text-danger">No Result Found</div>
                            @else
                            <!-- Looping through the jobs and displaying their details -->
                            @foreach($jobs as $item)
                            @php
                            // Retrieving the company ID and checking if the company's active order is valid
                            $this_company_id = $item->rCompany->id;
                            $order_data = \App\Models\Order::where('company_id', $this_company_id)
                            ->where('currently_active', 1)
                            ->first();

                            // If no active order or if the order has expired, skip the job
                            if (!$order_data || date('Y-m-d') > $order_data->expire_date) {
                            continue;
                            }
                            @endphp

                            <!-- Displaying each job listing -->
                            <div class="col-md-12">
                                <div class="item d-flex justify-content-start">
                                    <!-- Company Logo -->
                                    <div class="logo">
                                        <img src="{{ asset('uploads/'.$item->rCompany->logo) }}" alt="">
                                    </div>
                                    <div class="text">
                                        <!-- Job Title and Company Name as a clickable link -->
                                        <h3><a href="{{ route('job',$item->id) }}">{{ $item->title }},
                                                {{ $item->rCompany->company_name }}</a></h3>

                                        <!-- Job Category and Location -->
                                        <div class="detail-1 d-flex justify-content-start">
                                            <div class="category">
                                                {{ $item->rJobCategory->name }}
                                            </div>
                                            <div class="location">
                                                {{ $item->rJobLocation->name }}
                                            </div>
                                        </div>

                                        <!-- Job Date, Salary Range, and Expiry Status -->
                                        <div class="detail-2 d-flex justify-content-start">
                                            <div class="date">
                                                {{ $item->created_at->diffForHumans() }}
                                            </div>
                                            <div class="budget">
                                                {{ $item->rJobSalaryRange->name }}
                                            </div>
                                            <!-- If the job has expired, display the "Expired" label -->
                                            @if(date('Y-m-d') > $item->deadline)
                                            <div class="expired">
                                                Expired
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Special labels: Featured, Job Type, Urgent -->
                                        <div class="special d-flex justify-content-start">
                                            @if($item->is_featured == 1)
                                            <div class="featured">
                                                Featured
                                            </div>
                                            @endif
                                            <div class="type">
                                                {{ $item->rJobType->name }}
                                            </div>
                                            @if($item->is_urgent == 1)
                                            <div class="urgent">
                                                Urgent
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Bookmarking functionality for Candidates (only visible if not logged in as a company) -->
                                        @if(!Auth::guard('company')->check())
                                        <div class="bookmark">
                                            @if(Auth::guard('candidate')->check())
                                            @php
                                            // Checking if the current candidate has bookmarked the job
                                            $count =
                                            \App\Models\CandidateBookmark::where('candidate_id',Auth::guard('candidate')->user()->id)
                                            ->where('job_id',$item->id)
                                            ->count();
                                            $bookmark_status = $count > 0 ? 'active' : '';
                                            @endphp
                                            @else
                                            @php $bookmark_status = ''; @endphp
                                            @endif
                                            <!-- Bookmark icon (can be toggled) -->
                                            <a href="{{ route('candidate_bookmark_add',$item->id) }}"><i
                                                    class="fas fa-bookmark {{ $bookmark_status }}"></i></a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Pagination for job listings -->
                            <div class="col-md-12">
                                {{ $jobs->appends($_GET)->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
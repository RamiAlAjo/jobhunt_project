@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->job_listing_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->job_listing_page_meta_description }}@endsection

@section('main_content')

<!-- Top Banner Section with Background Image for Job Listing -->
<div class="page-top page-top-job-single"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_job_detail) }}')">
    <div class="bg"></div> <!-- Background overlay for visual enhancement -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 job job-single">
                <div class="item d-flex justify-content-start">
                    <!-- Company Logo -->
                    <div class="logo">
                        <img src="{{ asset('uploads/'.$job_single->rCompany->logo) }}" alt="" />
                    </div>

                    <!-- Job Details Section -->
                    <div class="text">
                        <!-- Job Title and Company Name -->
                        <h3>{{ $job_single->title }}, {{ $job_single->rCompany->company_name }}</h3>

                        <!-- Job Category and Location -->
                        <div class="detail-1 d-flex justify-content-start">
                            <div class="category">
                                {{ $job_single->rJobCategory->name }}
                            </div>
                            <div class="location">
                                {{ $job_single->rJobLocation->name }}
                            </div>
                        </div>

                        <!-- Job Post Date, Salary Range, and Expiry Status -->
                        <div class="detail-2 d-flex justify-content-start">
                            <div class="date">
                                {{ $job_single->created_at->diffForHumans() }}
                                <!-- Human-readable format for job post date -->
                            </div>
                            <div class="budget">
                                {{ $job_single->rJobSalaryRange->name }}
                            </div>

                            <!-- Check if Job is Expired -->
                            @if(date('Y-m-d') > $job_single->deadline)
                            <div class="expired">
                                Expired
                            </div>
                            @endif
                        </div>

                        <!-- Job Tags (Featured, Type, Urgent) -->
                        <div class="special d-flex justify-content-start">
                            @if($job_single->is_featured == 1)
                            <div class="featured">
                                Featured
                            </div>
                            @endif
                            <div class="type">
                                {{ $job_single->rJobType->name }}
                            </div>
                            @if($job_single->is_urgent == 1)
                            <div class="urgent">
                                Urgent
                            </div>
                            @endif
                        </div>

                        <!-- Apply and Bookmark Buttons (Visible for Candidates Only) -->
                        @if(!Auth::guard('company')->check())
                        <!-- Apply and bookmark buttons are shown if user is not a company -->
                        <div class="apply">
                            @if(date('Y-m-d') <= $job_single->deadline)
                                <!-- Show Apply button if the job has not expired -->
                                <a href="{{ route('candidate_apply',$job_single->id) }}" class="btn btn-primary">Apply
                                    Now</a>
                                <a href="{{ route('candidate_bookmark_add',$job_single->id) }}"
                                    class="btn btn-primary save-job">Bookmark</a>
                                @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Description Section -->
<div class="job-result pt-50 pb-50">
    <div class="container">
        <div class="row">
            <!-- Main Job Content (Left Side) -->
            <div class="col-lg-8 col-md-12">
                <!-- Job Description, Responsibilities, Skills, and Qualifications -->
                <div class="left-item">
                    <h2><i class="fas fa-file-invoice"></i> Description</h2>
                    <!-- Displaying the job description in HTML format -->
                    <p>{!! $job_single->description !!}</p>
                </div>
                <div class="left-item">
                    <h2><i class="fas fa-file-invoice"></i> Job Responsibilities</h2>
                    <!-- Job responsibilities in HTML format -->
                    {!! $job_single->responsibility !!}
                </div>
                <div class="left-item">
                    <h2><i class="fas fa-file-invoice"></i> Skills and Abilities</h2>
                    <!-- Job required skills in HTML format -->
                    {!! $job_single->skill !!}
                </div>
                <div class="left-item">
                    <h2><i class="fas fa-file-invoice"></i> Educational Qualification</h2>
                    <!-- Job educational qualifications in HTML format -->
                    {!! $job_single->education !!}
                </div>
                <div class="left-item">
                    <h2><i class="fas fa-file-invoice"></i> Benefits</h2>
                    <!-- Job benefits in HTML format -->
                    {!! $job_single->benefit !!}
                </div>

                <!-- Apply Now Button if Job is Active (Before Deadline) -->
                @if(date('Y-m-d') <= $job_single->deadline)
                    <div class="left-item">
                        <div class="apply">
                            <!-- Apply button shown only if job has not expired -->
                            <a href="apply.html" class="btn btn-primary">Apply Now</a>
                        </div>
                    </div>
                    @endif

                    <!-- Related Jobs Section -->
                    <div class="left-item">
                        <h2><i class="fas fa-file-invoice"></i> Related Jobs</h2>
                        <div class="job related-job pt-0 pb-0">
                            <div class="container">
                                <div class="row">
                                    @php $i = 0; @endphp
                                    @foreach($jobs as $item)
                                    @if($item->id == $job_single->id)
                                    @continue
                                    <!-- Skip the current job from being shown in the related jobs section -->
                                    @endif
                                    @php $i++; @endphp
                                    <div class="col-md-12">
                                        <div class="item d-flex justify-content-start">
                                            <div class="logo">
                                                <img src="{{ asset('uploads/'.$item->rCompany->logo) }}" alt="">
                                            </div>
                                            <div class="text">
                                                <h3><a href="{{ route('job',$item->id) }}">{{ $item->title }},
                                                        {{ $item->rCompany->company_name }}</a></h3>
                                                <!-- Display job category and location -->
                                                <div class="detail-1 d-flex justify-content-start">
                                                    <div class="category">
                                                        {{ $item->rJobCategory->name }}
                                                    </div>
                                                    <div class="location">
                                                        {{ $item->rJobLocation->name }}
                                                    </div>
                                                </div>
                                                <!-- Display job post date and salary range -->
                                                <div class="detail-2 d-flex justify-content-start">
                                                    <div class="date">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </div>
                                                    <div class="budget">
                                                        {{ $item->rJobSalaryRange->name }}
                                                    </div>
                                                    <!-- Check if job is expired -->
                                                    @if(date('Y-m-d') > $item->deadline)
                                                    <div class="expired">
                                                        Expired
                                                    </div>
                                                    @endif
                                                </div>
                                                <!-- Job tags for featured, type, and urgency -->
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
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- Show message if no related jobs are found -->
                                    @if($i == 0)
                                    <div class="text-danger">No Result Found</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Job Summary Section (Right Sidebar) -->
            <div class="col-lg-4 col-md-12">
                <div class="right-item">
                    <h2><i class="fas fa-file-invoice"></i> Job Summary</h2>
                    <div class="summary">
                        <div class="table-responsive">
                            <!-- Job Summary Table with details like published date, deadline, etc. -->
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>Published On:</b></td>
                                    <td>{{ $job_single->created_at->format('d F, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Deadline:</b></td>
                                    <td>{{ \Carbon\Carbon::parse($job_single->deadline)->format('d F, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Vacancy:</b></td>
                                    <td>{{ $job_single->vacancy }}</td>
                                </tr>
                                <tr>
                                    <td><b>Category:</b></td>
                                    <td>{{ $job_single->rJobCategory->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Location:</b></td>
                                    <td>{{ $job_single->rJobLocation->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Type:</b></td>
                                    <td>{{ $job_single->rJobType->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Experience:</b></td>
                                    <td>{{ $job_single->rJobExperience->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Gender:</b></td>
                                    <td>{{ $job_single->rJobGender->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Salary Range:</b></td>
                                    <td>{{ $job_single->rJobSalaryRange->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Job Enquiry Form -->
                <div class="right-item">
                    <h2><i class="fas fa-file-invoice"></i> Enquiry Form</h2>
                    <div class="enquery-form">
                        <!-- Enquiry form allowing users to send questions about the job -->
                        <form action="{{ route('job_enquery_send_email') }}" method="post">
                            @csrf
                            <!-- Hidden fields for company email and job title -->
                            <input type="hidden" name="receive_email" value="{{ $job_single->rCompany->email }}">
                            <input type="hidden" name="job_title" value="{{ $job_single->title }}">
                            <div class="mb-3">
                                <input type="text" name="visitor_name" class="form-control" placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <input type="email" name="visitor_email" class="form-control"
                                    placeholder="Email Address">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="visitor_phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="mb-3">
                                <textarea name="visitor_message" class="form-control h-150" rows="3"
                                    placeholder="Message"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Location Map (If available) -->
                @if($job_single->map_code != null)
                <div class="right-item">
                    <h2><i class="fas fa-file-invoice"></i> Location Map</h2>
                    <div class="location-map">
                        <!-- Display Google Maps embed code if available -->
                        {!! $job_single->map_code !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
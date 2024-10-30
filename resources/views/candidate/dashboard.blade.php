@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall page structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <!-- Banner section with a background image specific to the candidate dashboard, dynamically loaded from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
                <!-- Page heading, displaying "Dashboard" prominently over the banner image -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content section specific to the user panel layout -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('candidate.sidebar')
                    <!-- Includes the candidate sidebar, which likely contains navigation options relevant to the candidate's profile, such as links to jobs, bookmarks, and settings -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area for displaying the dashboard statistics -->

                <h3>Hello, {{ Auth::guard('candidate')->user()->name }}</h3>
                <!-- Personalized greeting using the candidate's name retrieved from the authenticated user's data -->

                <p>See all the statistics at a glance:</p>
                <!-- Introductory text explaining the purpose of the statistics section -->

                <div class="row box-items">
                    <!-- Row container for the statistics boxes -->

                    <div class="col-md-4">
                        <div class="box1">
                            <h4>{{ $total_applied_jobs }}</h4>
                            <p>Applied Jobs</p>
                            <!-- Displays the total number of jobs the candidate has applied for, within a styled box -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box2">
                            <h4>{{ $total_approved_jobs }}</h4>
                            <p>Approved Jobs</p>
                            <!-- Displays the total number of jobs that have been approved for the candidate, within a styled box -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box3">
                            <h4>{{ $total_rejected_jobs }}</h4>
                            <p>Rejected Jobs</p>
                            <!-- Displays the total number of jobs that have been rejected for the candidate, within a styled box -->
                        </div>
                    </div>
                </div>
                <!-- End of statistics boxes -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
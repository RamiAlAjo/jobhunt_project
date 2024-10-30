@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall page structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <!-- Banner section with a background image specific to the company panel, dynamically loaded from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
                <!-- Page heading, indicating that this is the company dashboard -->
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
                    @include('company.sidebar')
                    <!-- Includes the company sidebar, which likely contains navigation options relevant to the company profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area for displaying company dashboard information -->

                <h3>Hello, {{ Auth::guard('company')->user()->person_name }}
                    ({{ Auth::guard('company')->user()->company_name }})</h3>
                <!-- Personalized greeting, using the authenticated user's name and company name from the 'company' guard -->

                <p>See all the statistics at a glance:</p>
                <!-- Introductory text explaining the statistics section -->

                <div class="row box-items">
                    <!-- Row container for the statistics boxes -->

                    <div class="col-md-4">
                        <div class="box1">
                            <h4>{{ $total_opened_jobs }}</h4>
                            <p>Open Jobs</p>
                            <!-- Displays the total number of open jobs in a styled box -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box2">
                            <h4>{{ $total_featured_jobs }}</h4>
                            <p>Featured Jobs</p>
                            <!-- Displays the total number of featured jobs in a styled box -->
                        </div>
                    </div>
                </div>

                <h3 class="mt-5">Recent Jobs</h3>
                <!-- Heading for the recent jobs table -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for recent job post data -->
                                <th>SL</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Is Featured?</th>
                                <th>Is Urgent?</th>
                            </tr>

                            @foreach($jobs as $item)
                            <!-- Loop through each job post item -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Sequential number for the current job post, using Blade's $loop->iteration -->

                                <td>{{ $item->title }}</td>
                                <!-- Displays the title of the job post -->

                                <td>{{ $item->rJobCategory->name }}</td>
                                <!-- Displays the job category associated with the job post -->

                                <td>{{ $item->rJobLocation->name }}</td>
                                <!-- Displays the job location associated with the job post -->

                                <td>
                                    <!-- Badge indicating whether the job is featured -->
                                    @if($item->is_featured == 1)
                                    <span class="badge bg-success">Featured</span>
                                    @else
                                    <span class="badge bg-danger">Not Featured</span>
                                    @endif
                                </td>

                                <td>
                                    <!-- Badge indicating whether the job is marked as urgent -->
                                    @if($item->is_urgent == 1)
                                    <span class="badge bg-danger">Urgent</span>
                                    @else
                                    <span class="badge bg-primary">Not Urgent</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying recent jobs data -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
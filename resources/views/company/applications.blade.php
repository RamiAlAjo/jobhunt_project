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
                <h2>Candidate Applications</h2>
                <!-- Page heading, indicating that this is the candidate applications section -->
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
                <h4>All Job Posts</h4>
                <!-- Section heading for the list of job posts -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for the job post data -->
                                <th>SL</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Is Featured?</th>
                                <th>Job Detail</th>
                                <th>Applicants</th>
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
                                    <!-- Link to the job detail page -->
                                    <a href="{{ route('job', $item->id) }}"
                                        class="badge bg-primary text-white">Detail</a>
                                </td>

                                <td>
                                    <!-- Link to view the list of applicants for this job -->
                                    <a href="{{ route('company_applicants', $item->id) }}"
                                        class="badge bg-primary text-white">Applicants</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying job posts data -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and page structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <!-- Banner section with a background image specific to the candidate panel, loaded dynamically from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Bookmarked Jobs</h2>
                <!-- Page heading, displaying "Bookmarked Jobs" prominently over the banner image -->
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
                    <!-- Includes the candidate sidebar, which likely contains navigation options relevant to the candidate's profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area for displaying the bookmarked jobs table -->

                @if(!$bookmarked_jobs->count())
                <div class="text-danger">No data found</div>
                <!-- Message displayed if there are no bookmarked jobs -->
                @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for the bookmarked jobs data -->
                                <th>SL</th>
                                <th>Job Title</th>
                                <th class="w-150">Detail</th>
                            </tr>

                            @foreach($bookmarked_jobs as $item)
                            <!-- Loop through each bookmarked job item for the candidate -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Displays the sequential number for the current job entry, using Blade's $loop->iteration -->

                                <td>{{ $item->rJob->title }}</td>
                                <!-- Displays the title of the bookmarked job -->

                                <td>
                                    <!-- Action buttons for viewing job details and deleting the bookmark -->
                                    <a href="{{ route('job', $item->job_id) }}"
                                        class="btn btn-primary btn-sm">Detail</a>
                                    <!-- Button linking to the job detail page using the job ID -->

                                    <a href="{{ route('candidate_bookmark_delete', $item->id) }}"
                                        class="btn btn-danger btn-sm"
                                        onClick="return confirm('Are you sure?');">Delete</a>
                                    <!-- Delete button linking to the 'candidate_bookmark_delete' route with the bookmark ID, includes a JavaScript confirmation prompt -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying bookmarked jobs data -->
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
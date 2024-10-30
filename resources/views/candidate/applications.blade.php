@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <!-- Top banner section with a background image, pulled dynamically from the 'global_banner_data' -->

    <div class="bg"></div>
    <!-- Additional overlay for styling effects on the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Applied Jobs</h2>
                <!-- Page heading, displayed prominently over the banner image -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content area specific to the user panel -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('candidate.sidebar')
                    <!-- Includes the candidate sidebar, which likely contains navigation options specific to the candidate profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main column for displaying the applied jobs table -->

                @if(!$applied_jobs->count())
                <div class="text-danger">No data found</div>
                <!-- Displays a message if there are no applied jobs -->
                @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for the applied jobs data -->
                                <th>SL</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Cover Letter</th>
                                <th class="w-100">Detail</th>
                            </tr>

                            @php $i=0; @endphp
                            <!-- Initializes a counter variable to keep track of each job entry for modal ID purposes -->

                            @foreach($applied_jobs as $item)
                            @php $i++; @endphp
                            <!-- Loop through each applied job item -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Displays the iteration number for the current item -->

                                <td>{{ $item->rJob->title }}</td>
                                <!-- Displays the job title associated with the applied job -->

                                <td>{{ $item->rJob->rCompany->company_name }}</td>
                                <!-- Displays the company name associated with the job -->

                                <td>
                                    <!-- Displays the application status with a color-coded badge -->
                                    @if($item->status == 'Applied')
                                    @php $color = 'primary'; @endphp
                                    @elseif($item->status == 'Approved')
                                    @php $color = 'success'; @endphp
                                    @elseif($item->status == 'Rejected')
                                    @php $color = 'danger'; @endphp
                                    @endif
                                    <div class="badge bg-{{ $color }}">
                                        {{ $item->status }}
                                    </div>
                                </td>

                                <td>
                                    <!-- Button to open a modal displaying the cover letter -->
                                    <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $i }}">Cover Letter</a>
                                </td>

                                <td>
                                    <!-- Button linking to the job details page -->
                                    <a href="{{ route('job', $item->rJob->id) }}"
                                        class="btn btn-primary btn-sm text-white"><i class="fas fa-eye"></i></a>

                                    <!-- Modal structure for displaying the cover letter -->
                                    <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cover Letter
                                                    </h1>
                                                    <!-- Modal title -->

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                    <!-- Close button for the modal -->
                                                </div>

                                                <div class="modal-body">
                                                    {!! nl2br($item->cover_letter) !!}
                                                    <!-- Displays the cover letter content with line breaks maintained -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- End of job entry row -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying applied jobs -->
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of the main content section -->
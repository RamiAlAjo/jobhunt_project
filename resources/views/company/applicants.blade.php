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
                <h2>Applicants of job: {{ $job_single->title }}</h2>
                <!-- Page heading, displaying the job title over the banner image -->
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
                <h4>Applicants of this job:</h4>
                <!-- Section heading for the list of applicants -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for the applicants data -->
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Detail</th>
                                <th>Cover Letter
                                </th>
                            </tr>

                            @php $i=0; @endphp
                            <!-- Initializes a counter variable for unique modal IDs -->

                            @foreach($applicants as $item)
                            @php $i++; @endphp
                            <!-- Loop through each applicant for the job -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Sequential number for the current applicant, using Blade's $loop->iteration -->

                                <td>{{ $item->rCandidate->name }}</td>
                                <!-- Displays the applicant's name -->

                                <td>{{ $item->rCandidate->email }}</td>
                                <!-- Displays the applicant's email -->

                                <td>{{ $item->rCandidate->phone }}</td>
                                <!-- Displays the applicant's phone number -->

                                <td>
                                    <!-- Status badge with dynamic color based on the application status -->
                                    @if($item->status == 'Applied')
                                    @php $color="primary"; @endphp
                                    @elseif($item->status == 'Approved')
                                    @php $color="success"; @endphp
                                    @elseif($item->status == 'Rejected')
                                    @php $color="danger"; @endphp
                                    @endif
                                    <span class="badge bg-{{ $color }}">{{ $item->status }}</span>
                                </td>

                                <td>
                                    <!-- Dropdown to change the application status -->
                                    <form action="{{ route('company_application_status_change') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="job_id" value="{{ $job_single->id }}">
                                        <input type="hidden" name="candidate_id" value="{{ $item->candidate_id }}">
                                        <select name="status" class="form-control select2 w_100"
                                            onchange="this.form.submit()">
                                            <option value="">Select</option>
                                            <option value="Applied">Applied</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                    </form>
                                </td>

                                <td>
                                    <!-- Link to view applicant's detailed profile/resume -->
                                    <a href="{{ route('company_applicant_resume', $item->candidate_id) }}"
                                        class="badge bg-primary text-white" target="_blank">Detail</a>
                                </td>

                                <td>
                                    <!-- Button to open a modal displaying the applicant's cover letter -->
                                    <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $i }}">Cover Letter
                                    </a>

                                    <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cover Letter
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! nl2br($item->cover_letter) !!}
                                                    <!-- Displays the applicant's cover letter, preserving line breaks -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying applicants data -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
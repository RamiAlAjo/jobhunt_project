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
                <h2>Detail of "{{ $candidate_single->name }}"</h2>
                <!-- Page heading, displaying the candidate's name prominently over the banner image -->
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
                <!-- Main content area for displaying candidate's resume information -->
                    <!-- Print Button -->
                    <button onclick="window.print()" class="btn btn-primary mb-3">Print Page</button>
                    
                <h4 class="resume">Basic Profile</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-200">Photo:</th>
                            <td>
                                <!-- Displays candidate's photo or a default photo if none is uploaded -->
                                @if($candidate_single->photo=='')
                                <img src="{{ asset('uploads/default_candidate_photo.png') }}" alt="" class="w-100">
                                @else
                                <img src="{{ asset('uploads/'.$candidate_single->photo) }}" alt="" class="w-100">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $candidate_single->name }}</td>
                            <!-- Displays candidate's name -->
                        </tr>

                        @if($candidate_single->designation!=null)
                        <tr>
                            <th>Designation:</th>
                            <td>{{ $candidate_single->designation }}</td>
                            <!-- Displays candidate's designation if available -->
                        </tr>
                        @endif

                        <tr>
                            <th>Email:</th>
                            <td>{{ $candidate_single->email }}</td>
                            <!-- Displays candidate's email address -->
                        </tr>

                        <!-- Conditional display for optional candidate information such as phone, address, etc. -->
                        @if($candidate_single->phone!=null)
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $candidate_single->phone }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->country!=null)
                        <tr>
                            <th>Country:</th>
                            <td>{{ $candidate_single->country }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->address!=null)
                        <tr>
                            <th>Address:</th>
                            <td>{{ $candidate_single->address }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->state!=null)
                        <tr>
                            <th>State:</th>
                            <td>{{ $candidate_single->state }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->city!=null)
                        <tr>
                            <th>City:</th>
                            <td>{{ $candidate_single->city }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->zip_code!=null)
                        <tr>
                            <th>Zip Code:</th>
                            <td>{{ $candidate_single->zip_code }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->gender!=null)
                        <tr>
                            <th>Gender:</th>
                            <td>{{ $candidate_single->gender }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->marital_status!=null)
                        <tr>
                            <th>Marital Status:</th>
                            <td>{{ $candidate_single->marital_status }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->date_of_birth!=null)
                        <tr>
                            <th>Date of Birth:</th>
                            <td>{{ $candidate_single->date_of_birth }}</td>
                        </tr>
                        @endif

                        @if($candidate_single->website!=null)
                        <tr>
                            <th>Website:</th>
                            <td><a href="{{ $candidate_single->website }}"
                                    target="_blank">{{ $candidate_single->website }}</a></td>
                            <!-- Displays candidate's website as a clickable link if available -->
                        </tr>
                        @endif

                        @if($candidate_single->biography!=null)
                        <tr>
                            <th>Biography:</th>
                            <td>
                                {!! $candidate_single->biography !!}
                                <!-- Displays candidate's biography allowing HTML formatting -->
                            </td>
                        </tr>
                        @endif

                    </table>
                </div>

                <!-- Sections for Education, Skills, Experience, Awards, and Resume -->
                <!-- Each section is displayed only if there is relevant data -->

                @if($candidate_educations->count())
                <h4 class="resume mt-5">Education</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Education Level</th>
                            <th>Institute</th>
                            <th>Degree</th>
                            <th>Passing Year</th>
                        </tr>
                        @foreach($candidate_educations as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->level }}</td>
                            <td>{{ $item->institute }}</td>
                            <td>{{ $item->degree }}</td>
                            <td>{{ $item->passing_year }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                @if($candidate_skills->count())
                <h4 class="resume mt-5">Skills</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Skill Name</th>
                            <th>Percentage</th>
                        </tr>
                        @foreach($candidate_skills as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->percentage }}%</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                @if($candidate_experiences->count())
                <h4 class="resume mt-5">Experience</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Company</th>
                            <th>Designation</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                        @foreach($candidate_experiences as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->company }}</td>
                            <td>{{ $item->designation }}</td>
                            <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                @if($candidate_awards->count())
                <h4 class="resume mt-5">Awards</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                        @foreach($candidate_awards as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->date }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                @if($candidate_resumes->count())
                <h4 class="resume mt-5">Resume</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>File</th>
                        </tr>
                        @foreach($candidate_resumes as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td><a href="{{ asset('uploads/'.$item->file) }}" target="_blank">{{ $item->file }}</a></td>
                            <!-- Link to download or view the resume file -->
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
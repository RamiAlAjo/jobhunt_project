@extends('admin.layout.app')

@section('heading', 'Candidate Detail')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Main card containing candidate details -->
            <div class="card">
                <div class="card-body">

                    <!-- Basic Information Section -->
                    <h5>Basic Information</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th class="w_200">Photo</th>
                                <td>
                                    <!-- Candidate photo -->
                                    <img src="{{ asset('uploads/'.$candidate_single->photo) }}" alt="" class="w_100">
                                </td>
                            </tr>
                            <tr>
                                <th class="w_200">Name</th>
                                <td>{{ $candidate_single->name }}</td>
                            </tr>
                            <!-- Additional candidate details like designation, username, email, phone, and address -->
                            <tr>
                                <th class="w_200">Designation</th>
                                <td>{{ $candidate_single->designation }}</td>
                            </tr>
                            <tr>
                                <th class="w_200">Username</th>
                                <td>{{ $candidate_single->username }}</td>
                            </tr>
                            <tr>
                                <th class="w_200">Email</th>
                                <td>{{ $candidate_single->email }}</td>
                            </tr>
                            <!-- More personal details like phone, country, address, state, city, etc. -->
                            <tr>
                                <th class="w_200">Phone</th>
                                <td>{{ $candidate_single->phone }}</td>
                            </tr>
                            <tr>
                                <th class="w_200">Country</th>
                                <td>{{ $candidate_single->country }}</td>
                            </tr>
                            <!-- Display remaining personal details in separate rows -->
                        </table>
                    </div>

                    <!-- Conditional Education Section -->
                    @if($candidate_educations->count())
                    <h5>Education</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Conditional Skills Section -->
                    @if($candidate_skills->count())
                    <h5>Skills</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Conditional Experience Section -->
                    @if($candidate_experiences->count())
                    <h5>Experience</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Conditional Awards Section -->
                    @if($candidate_awards->count())
                    <h5>Awards</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th class="w_100">Date</th>
                                </tr>
                                @foreach($candidate_awards as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->date }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Conditional Resumes Section -->
                    @if($candidate_resumes->count())
                    <h5>Resume</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>File</th>
                                </tr>
                                @foreach($candidate_resumes as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <!-- Resume file download link -->
                                    <td><a href="{{ asset('uploads/'.$item->file) }}"
                                            target="_blank">{{ $item->file }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
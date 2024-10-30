@extends('front.layout.app')
<!-- Extends the front layout template, including shared elements like the header and footer -->

@section('main_content')
<!-- Main content section for the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <!-- Top section with a background image specific to the company panel -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Job</h2>
                <!-- Heading for the Edit Job page -->
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
                    <!-- Includes the company sidebar, which contains navigation options for the company profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main form section for editing the job details -->

                <form action="{{ route('company_jobs_update',$jobs_single->id) }}" method="post">
                    @csrf
                    <!-- Submits the form data for updating the job details -->

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ $jobs_single->title }}">
                            <!-- Input field for job title, pre-filled with the current job title -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Description *</label>
                        <textarea name="description" class="form-control editor" cols="30"
                            rows="10">{{ $jobs_single->description }}</textarea>
                        <!-- Textarea for job description, pre-filled with the current description -->
                    </div>

                    <!-- Fields for job responsibilities and required skills, each pre-filled with current job data -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Job Responsibilities</label>
                            <textarea name="responsibility" class="form-control editor" cols="30"
                                rows="10">{{ $jobs_single->responsibility }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Skills and Abilities</label>
                            <textarea name="skill" class="form-control editor" cols="30"
                                rows="10">{{ $jobs_single->skill }}</textarea>
                        </div>
                    </div>

                    <!-- Fields for educational qualifications and job benefits, each pre-filled with current job data -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Educational Qualification</label>
                            <textarea name="education" class="form-control editor" cols="30"
                                rows="10">{{ $jobs_single->education }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Benefits</label>
                            <textarea name="benefit" class="form-control editor" cols="30"
                                rows="10">{{ $jobs_single->benefit }}</textarea>
                        </div>
                    </div>

                    <!-- Fields for job deadline and vacancy count -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Deadline *</label>
                            <input type="text" name="deadline" class="form-control datepicker"
                                value="{{ $jobs_single->deadline }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Vacancy *</label>
                            <input type="number" class="form-control" name="vacancy" min="1"
                                value="{{ $jobs_single->vacancy }}">
                        </div>
                    </div>

                    <!-- Dropdowns for job category, location, type, experience, gender preference, and salary range -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Job Category *</label>
                            <select name="job_category_id" class="form-control select2">
                                @foreach($job_categories as $item)
                                <option value="{{ $item->id }}" @if($item->id == $jobs_single->job_category_id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for job category, with the current category selected -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Location *</label>
                            <select name="job_location_id" class="form-control select2">
                                @foreach($job_locations as $item)
                                <option value="{{ $item->id }}" @if($item->id == $jobs_single->job_location_id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for job location, with the current location selected -->
                            </select>
                        </div>
                    </div>

                    <!-- Dropdowns for job type and experience level -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Job Type *</label>
                            <select name="job_type_id" class="form-control select2">
                                @foreach($job_types as $item)
                                <option value="{{ $item->id }}" @if($item->id == $jobs_single->job_type_id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for job type, with the current type selected -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Experience *</label>
                            <select name="job_experience_id" class="form-control select2">
                                @foreach($job_experiences as $item)
                                <option value="{{ $item->id }}" @if($item->id == $jobs_single->job_experience_id)
                                    selected @endif>{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for experience level, with the current level selected -->
                            </select>
                        </div>
                    </div>

                    <!-- Dropdowns for gender preference and salary range -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Gender *</label>
                            <select name="job_gender_id" class="form-control select2">
                                @foreach($job_genders as $item)
                                <option value="{{ $item->id }}" @if($item->id == $jobs_single->job_gender_id) selected
                                    @endif>{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for gender preference, with the current gender selected -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Salary Range *</label>
                            <select name="job_salary_range_id" class="form-control select2">
                                @foreach($job_salary_ranges as $item)
                                <option value="{{ $item->id }}" @if($item->id == $jobs_single->job_salary_range_id)
                                    selected @endif>{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for salary range, with the current range selected -->
                            </select>
                        </div>
                    </div>

                    <!-- Textarea for location map (optional) -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Location Map</label>
                            <textarea name="map_code" class="form-control h-150" cols="30"
                                rows="10">{{ $jobs_single->map_code }}</textarea>
                        </div>
                    </div>

                    <!-- Dropdowns for job features (Is Featured? Is Urgent?) -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Is Featured?</label>
                            <select name="is_featured" class="form-control select2">
                                <option value="0" @if($jobs_single->is_featured == 0) selected @endif>No</option>
                                <option value="1" @if($jobs_single->is_featured == 1) selected @endif>Yes</option>
                                <!-- Dropdown for featured job selection, with the current value selected -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Is Urgent?</label>
                            <select name="is_urgent" class="form-control select2">
                                <option value="0" @if($jobs_single->is_urgent == 0) selected @endif>No</option>
                                <option value="1" @if($jobs_single->is_urgent == 1) selected @endif>Yes</option>
                                <!-- Dropdown for urgent job selection, with the current value selected -->
                            </select>
                        </div>
                    </div>

                    <!-- Submit button for updating the job -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
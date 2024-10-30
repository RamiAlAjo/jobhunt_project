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
                <h2>Create New Job</h2>
                <!-- Page heading indicating that the user is creating a new job post -->
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
                <!-- Main content area for displaying the Create New Job form -->

                <form action="{{ route('company_jobs_create_submit') }}" method="post">
                    @csrf
                    <!-- Form submission to create a new job post, with the route 'company_jobs_create_submit' -->

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            <!-- Input for job title, with old input data for error recovery -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Description *</label>
                        <textarea name="description" class="form-control editor" cols="30"
                            rows="10">{{ old('description') }}</textarea>
                        <!-- Textarea for job description with a WYSIWYG editor class -->
                    </div>

                    <!-- Additional fields for job details (responsibilities, skills, education, benefits) -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Job Responsibilities</label>
                            <textarea name="responsibility" class="form-control editor" cols="30"
                                rows="10">{{ old('responsibility') }}</textarea>
                            <!-- Textarea for job responsibilities -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Skills and Abilities</label>
                            <textarea name="skill" class="form-control editor" cols="30"
                                rows="10">{{ old('skill') }}</textarea>
                            <!-- Textarea for skills and abilities required for the job -->
                        </div>
                    </div>

                    <!-- Educational qualification and benefits fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Educational Qualification</label>
                            <textarea name="education" class="form-control editor" cols="30"
                                rows="10">{{ old('education') }}</textarea>
                            <!-- Textarea for educational qualifications -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Benefits</label>
                            <textarea name="benefit" class="form-control editor" cols="30"
                                rows="10">{{ old('benefit') }}</textarea>
                            <!-- Textarea for job benefits -->
                        </div>
                    </div>

                    <!-- Job deadline and vacancy count -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Deadline *</label>
                            <input type="text" name="deadline" class="form-control datepicker"
                                value="{{ old('deadline') ? old('deadline') : date('Y-m-d') }}">
                            <!-- Datepicker for job application deadline -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Vacancy *</label>
                            <input type="number" class="form-control" name="vacancy" min="1"
                                value="{{ old('vacancy') ? old('vacancy') : '1' }}">
                            <!-- Input for the number of vacancies, defaulting to 1 -->
                        </div>
                    </div>

                    <!-- Dropdowns for job category, location, type, experience, gender, and salary range -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Job Category *</label>
                            <select name="job_category_id" class="form-control select2">
                                @foreach($job_categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for job category selection -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Location *</label>
                            <select name="job_location_id" class="form-control select2">
                                @foreach($job_locations as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for job location selection -->
                            </select>
                        </div>
                    </div>

                    <!-- Dropdowns for job type and experience -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Job Type *</label>
                            <select name="job_type_id" class="form-control select2">
                                @foreach($job_types as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for job type selection -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Experience *</label>
                            <select name="job_experience_id" class="form-control select2">
                                @foreach($job_experiences as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for experience level selection -->
                            </select>
                        </div>
                    </div>

                    <!-- Dropdowns for job gender preference and salary range -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Gender *</label>
                            <select name="job_gender_id" class="form-control select2">
                                @foreach($job_genders as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for gender preference selection -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Salary Range *</label>
                            <select name="job_salary_range_id" class="form-control select2">
                                @foreach($job_salary_ranges as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <!-- Dropdown for salary range selection -->
                            </select>
                        </div>
                    </div>

                    <!-- Map location (optional) -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Location Map</label>
                            <textarea name="map_code" class="form-control h-150" cols="30"
                                rows="10">{{ old('map_code') }}</textarea>
                            <!-- Textarea for Google Maps embed code for job location -->
                        </div>
                    </div>

                    <!-- Dropdowns for job features (Is Featured? Is Urgent?) -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Is Featured?</label>
                            <select name="is_featured" class="form-control select2">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                                <!-- Dropdown for selecting if the job is featured -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Is Urgent?</label>
                            <select name="is_urgent" class="form-control select2">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                                <!-- Dropdown for selecting if the job is urgent -->
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <!-- Submit button to create the job post -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
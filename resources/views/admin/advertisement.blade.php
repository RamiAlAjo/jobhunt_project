@extends('admin.layout.app')  <!-- Extend the base layout for the admin panel -->

@section('heading', 'Advertisement')  <!-- Set the heading for the page -->

@section('main_content')  <!-- Main content section of the page -->
<div class="section-body">
    <div class="row">
        <div class="col-md-6">
            <!-- Card Container for Advertisement Form -->
            <div class="card">
                <div class="card-body">
                    <!-- Form for updating advertisement details -->
                    <form action="{{ route('admin_advertisement_update') }}" method="post" enctype="multipart/form-data">
                        @csrf  <!-- CSRF token for form security -->

                        <!-- Section for Job Listing Advertisement -->
                        <h4>Job Listing Ad</h4>
                        <div class="form-group mb-3">
                            <label>Existing Job Listing Ad</label>
                            <div>
                                <!-- Display the current job listing advertisement -->
                                <img src="{{ asset('uploads/'.$advertisement_data->job_listing_ad) }}" alt="" class="w_200">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Change Job Listing Ad</label>
                            <div>
                                <!-- File input for uploading a new job listing advertisement -->
                                <input type="file" name="job_listing_ad">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>URL</label>
                            <!-- Text input for the URL associated with the job listing advertisement -->
                            <input type="text" name="job_listing_ad_url" class="form-control" value="{{ $advertisement_data->job_listing_ad_url }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Status</label>
                            <!-- Dropdown to select the visibility status of the job listing advertisement -->
                            <select name="job_listing_ad_status" class="form-control select2">
                                <option value="Show" @if($advertisement_data->job_listing_ad_status == 'Show') selected @endif>Show</option>
                                <option value="Hide" @if($advertisement_data->job_listing_ad_status == 'Hide') selected @endif>Hide</option>
                            </select>
                        </div>

                        <!-- Section for Company Listing Advertisement -->
                        <h4>Company Listing Ad</h4>
                        <div class="form-group mb-3">
                            <label>Existing Company Listing Ad</label>
                            <div>
                                <!-- Display the current company listing advertisement -->
                                <img src="{{ asset('uploads/'.$advertisement_data->company_listing_ad) }}" alt="" class="w_200">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Change Company Listing Ad</label>
                            <div>
                                <!-- File input for uploading a new company listing advertisement -->
                                <input type="file" name="company_listing_ad">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>URL</label>
                            <!-- Text input for the URL associated with the company listing advertisement -->
                            <input type="text" name="company_listing_ad_url" class="form-control" value="{{ $advertisement_data->company_listing_ad_url }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Status</label>
                            <!-- Dropdown to select the visibility status of the company listing advertisement -->
                            <select name="company_listing_ad_status" class="form-control select2">
                                <option value="Show" @if($advertisement_data->company_listing_ad_status == 'Show') selected @endif>Show</option>
                                <option value="Hide" @if($advertisement_data->company_listing_ad_status == 'Hide') selected @endif>Hide</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <!-- Button to submit the form for updating advertisements -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

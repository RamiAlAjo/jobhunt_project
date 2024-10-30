@extends('admin.layout.app')
<!-- Extends the admin layout, which includes styles, scripts, and overall structure for the admin pages -->

@section('heading', 'Other Page Content')
<!-- Sets the heading section to "Other Page Content" to be displayed on the page -->

@section('main_content')
<!-- Starts the main content section for this page -->

<div class="section-body">
    <!-- Container for the section content -->

    <div class="row">
        <!-- Bootstrap row for responsive layout -->

        <div class="col-12">
            <!-- Full-width column for larger screen sizes, containing the card component -->

            <div class="card">
                <!-- Bootstrap card component for a styled container -->

                <div class="card-body">
                    <!-- Card body containing the form for updating other page content -->

                    <form action="{{ route('admin_other_page_update') }}" method="post" enctype="multipart/form-data">
                        <!-- Form submission with POST method to the 'admin_other_page_update' route, supporting file uploads -->

                        @csrf
                        <!-- CSRF token for security against cross-site request forgery -->

                        <div class="row custom-tab">
                            <!-- Custom tab container for the navigation and tab content areas -->

                            <div class="col-lg-3 col-md-12">
                                <!-- Column for the navigation tabs on larger screens (stacked vertically on smaller screens) -->

                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <!-- Vertical navigation for tabs with Bootstrap pills -->

                                    <!-- Navigation buttons for each section of the other page content -->
                                    <button class="nav-link active" id="v-pills-1-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-1" type="button" role="tab" aria-controls="v-pills-1"
                                        aria-selected="true">Login Page</button>
                                    <button class="nav-link" id="v-pills-2-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-2" type="button" role="tab" aria-controls="v-pills-2"
                                        aria-selected="false">Signup Page</button>
                                    <button class="nav-link" id="v-pills-3-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-3" type="button" role="tab" aria-controls="v-pills-3"
                                        aria-selected="false">Forget Password Page</button>
                                    <button class="nav-link" id="v-pills-4-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-4" type="button" role="tab" aria-controls="v-pills-4"
                                        aria-selected="false">Job Listing Page</button>
                                    <button class="nav-link" id="v-pills-5-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-5" type="button" role="tab" aria-controls="v-pills-5"
                                        aria-selected="false">Company Listing Page</button>
                                </div>
                            </div>

                            <div class="col-lg-9 col-md-12">
                                <!-- Column for the tab content, responsive to different screen sizes -->

                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- Container for the content of each tab -->

                                    <!-- Each section below corresponds to a different tab for updating content -->

                                    <!-- Login Page Tab Content -->
                                    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel"
                                        aria-labelledby="v-pills-1-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Full-width column for the tab content -->

                                                <div class="mb-4">
                                                    <label class="form-label">Heading *</label>
                                                    <input type="text" class="form-control" name="login_page_heading"
                                                        value="{{ $page_other_data->login_page_heading }}">
                                                    <!-- Input field for Login Page heading -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="login_page_title"
                                                        value="{{ $page_other_data->login_page_title }}">
                                                    <!-- Input field for Login Page title -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea name="login_page_meta_description"
                                                        class="form-control h_100" cols="30"
                                                        rows="10">{{ $page_other_data->login_page_meta_description }}</textarea>
                                                    <!-- Textarea for Login Page meta description -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Signup Page Tab Content -->
                                    <div class="tab-pane fade" id="v-pills-2" role="tabpanel"
                                        aria-labelledby="v-pills-2-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4">
                                                    <label class="form-label">Heading *</label>
                                                    <input type="text" class="form-control" name="signup_page_heading"
                                                        value="{{ $page_other_data->signup_page_heading }}">
                                                    <!-- Input field for Signup Page heading -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="signup_page_title"
                                                        value="{{ $page_other_data->signup_page_title }}">
                                                    <!-- Input field for Signup Page title -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea name="signup_page_meta_description"
                                                        class="form-control h_100" cols="30"
                                                        rows="10">{{ $page_other_data->signup_page_meta_description }}</textarea>
                                                    <!-- Textarea for Signup Page meta description -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Forget Password Page Tab Content -->
                                    <div class="tab-pane fade" id="v-pills-3" role="tabpanel"
                                        aria-labelledby="v-pills-3-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4">
                                                    <label class="form-label">Heading *</label>
                                                    <input type="text" class="form-control"
                                                        name="forget_password_page_heading"
                                                        value="{{ $page_other_data->forget_password_page_heading }}">
                                                    <!-- Input field for Forget Password Page heading -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                        name="forget_password_page_title"
                                                        value="{{ $page_other_data->forget_password_page_title }}">
                                                    <!-- Input field for Forget Password Page title -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea name="forget_password_page_meta_description"
                                                        class="form-control h_100" cols="30"
                                                        rows="10">{{ $page_other_data->forget_password_page_meta_description }}</textarea>
                                                    <!-- Textarea for Forget Password Page meta description -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Job Listing Page Tab Content -->
                                    <div class="tab-pane fade" id="v-pills-4" role="tabpanel"
                                        aria-labelledby="v-pills-4-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4">
                                                    <label class="form-label">Heading *</label>
                                                    <input type="text" class="form-control"
                                                        name="job_listing_page_heading"
                                                        value="{{ $page_other_data->job_listing_page_heading }}">
                                                    <!-- Input field for Job Listing Page heading -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                        name="job_listing_page_title"
                                                        value="{{ $page_other_data->job_listing_page_title }}">
                                                    <!-- Input field for Job Listing Page title -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea name="job_listing_page_meta_description"
                                                        class="form-control h_100" cols="30"
                                                        rows="10">{{ $page_other_data->job_listing_page_meta_description }}</textarea>
                                                    <!-- Textarea for Job Listing Page meta description -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Company Listing Page Tab Content -->
                                    <div class="tab-pane fade" id="v-pills-5" role="tabpanel"
                                        aria-labelledby="v-pills-5-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4">
                                                    <label class="form-label">Heading *</label>
                                                    <input type="text" class="form-control"
                                                        name="company_listing_page_heading"
                                                        value="{{ $page_other_data->company_listing_page_heading }}">
                                                    <!-- Input field for Company Listing Page heading -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                        name="company_listing_page_title"
                                                        value="{{ $page_other_data->company_listing_page_title }}">
                                                    <!-- Input field for Company Listing Page title -->
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea name="company_listing_page_meta_description"
                                                        class="form-control h_100" cols="30"
                                                        rows="10">{{ $page_other_data->company_listing_page_meta_description }}</textarea>
                                                    <!-- Textarea for Company Listing Page meta description -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-4">
                                    <label class="form-label"></label>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <!-- Submit button to save all changes across all sections -->
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- End of form element -->

                </div>
                <!-- End of card body -->
            </div>
            <!-- End of card component -->
        </div>
        <!-- End of column -->
    </div>
    <!-- End of row layout -->
</div>
<!-- End of section body container -->
@endsection
<!-- End of main content section -->
@extends('admin.layout.app')
<!-- Extends the base admin layout template, which includes common styles and scripts for all admin pages -->

@section('heading', 'Create Package')
<!-- Sets the 'heading' section for the page title to "Create Package" -->

@section('button')
<!-- Defines the 'button' section, adding a button for navigation -->

<div>
    <a href="{{ route('admin_package') }}" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
    <!-- Button linking to the 'admin_package' route to view all packages, with a Font Awesome icon and primary styling -->
</div>
@endsection

@section('main_content')
<!-- Starts the 'main_content' section for the main body of the page -->

<div class="section-body">
    <!-- Wrapper div for the main section content -->

    <div class="row">
        <!-- Bootstrap row for responsive layout -->

        <div class="col-12">
            <!-- Full-width column to hold the card -->

            <div class="card">
                <!-- Bootstrap card component to contain the form -->

                <div class="card-body">
                    <!-- Card body where the form is located -->

                    <form action="{{ route('admin_package_store') }}" method="post">
                        <!-- Form to submit data via POST to the 'admin_package_store' route -->

                        @csrf
                        <!-- Laravel Blade directive for CSRF token to protect against cross-site request forgery -->

                        <div class="row">
                            <!-- Bootstrap row for the first set of input fields -->

                            <div class="col-md-6">
                                <!-- Column for 'Package Name' input, occupying half the width on medium and larger screens -->

                                <div class="form-group mb-3">
                                    <!-- Form group with margin-bottom for spacing -->

                                    <label>Package Name *</label>
                                    <!-- Label for the 'Package Name' input field -->

                                    <input type="text" class="form-control" name="package_name">
                                    <!-- Text input for the package name, with 'form-control' class for styling -->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Column for 'Package Price' input, also half-width on medium and larger screens -->

                                <div class="form-group mb-3">
                                    <label>Package Price *</label>
                                    <!-- Label for 'Package Price' input -->

                                    <input type="text" class="form-control" name="package_price">
                                    <!-- Text input for the package price -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Bootstrap row for the second set of input fields -->

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Number of Days *</label>
                                    <!-- Label for 'Number of Days' input -->

                                    <input type="text" class="form-control" name="package_days">
                                    <!-- Text input for the number of days the package is valid -->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Display Time *</label>
                                    <!-- Label for 'Display Time' input -->

                                    <input type="text" class="form-control" name="package_display_time">
                                    <!-- Text input for the display time of the package -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Bootstrap row for the third set of input fields -->

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Total Allowed Jobs *</label>
                                    <!-- Label for 'Total Allowed Jobs' input -->

                                    <input type="text" class="form-control" name="total_allowed_jobs">
                                    <!-- Text input for the total number of jobs allowed in the package -->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Total Allowed Featured Jobs *</label>
                                    <!-- Label for 'Total Allowed Featured Jobs' input -->

                                    <input type="text" class="form-control" name="total_allowed_featured_jobs">
                                    <!-- Text input for the number of featured jobs allowed -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Bootstrap row for the fourth set of input fields -->

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Total Allowed Photos *</label>
                                    <!-- Label for 'Total Allowed Photos' input -->

                                    <input type="text" class="form-control" name="total_allowed_photos">
                                    <!-- Text input for the total number of photos allowed in the package -->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Total Allowed Videos *</label>
                                    <!-- Label for 'Total Allowed Videos' input -->

                                    <input type="text" class="form-control" name="total_allowed_videos">
                                    <!-- Text input for the total number of videos allowed in the package -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Form group for the submit button -->

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <!-- Button to submit the form, styled as a primary button -->
                        </div>
                    </form>
                    <!-- End of form -->
                </div>
                <!-- End of card body -->
            </div>
            <!-- End of card -->
        </div>
        <!-- End of column -->
    </div>
    <!-- End of row -->
</div>
<!-- End of section body -->
@endsection
<!-- End of main_content section -->
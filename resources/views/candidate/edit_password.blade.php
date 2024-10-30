@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <!-- Banner section with a background image specific to the candidate panel, dynamically loaded from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Password</h2>
                <!-- Page heading, displaying "Edit Password" prominently over the banner image -->
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
                    <!-- Includes the candidate sidebar, which likely contains navigation options for various profile settings and features -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area for displaying the password update form -->

                <form action="{{ route('candidate_edit_password_update') }}" method="post">
                    <!-- Form submission to the 'candidate_edit_password_update' route with POST method -->

                    @csrf
                    <!-- CSRF token for security to prevent cross-site request forgery -->

                    <div class="row">
                        <!-- Row for organizing form fields -->

                        <div class="col-md-6 mb-3">
                            <label for="">New Password *</label>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control">
                                <!-- Input field for entering the new password -->
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Retype Password *</label>
                            <div class="form-group">
                                <input type="password" name="retype_password" class="form-control">
                                <!-- Input field for retyping the new password to confirm -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <!-- Submit button to update the password -->
                        </div>
                    </div>
                </form>
                <!-- End of form for updating password -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
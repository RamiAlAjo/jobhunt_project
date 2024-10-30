@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->forget_password_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->forget_password_page_meta_description }}@endsection

@section('main_content')

<!-- Top Banner Section -->
<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_forget_password) }}')">
    <div class="bg"></div> <!-- Background overlay for styling -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Heading of the Forget Password Page -->
                <h2>{{ $other_page_item->forget_password_page_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area for Forget Password Form -->
<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <!-- Login Form Container -->
                <div class="login-form">
                    <!-- Form Submission for Forget Password -->
                    <form action="{{ route('candidate_forget_password_submit') }}" method="post">

                        <!-- CSRF Token for Security -->
                        @csrf

                        <!-- Input Field for Email Address -->
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter your email"
                                required>
                            <!-- Placeholder and 'required' attribute added for better UX -->
                        </div>

                        <!-- Submit Button and Back to Login Page Link -->
                        <div class="mb-3">
                            <!-- Submit Button to Send Password Reset Request -->
                            <button type="submit" class="btn btn-primary bg-website">
                                Submit
                            </button>

                            <!-- Link to Redirect User Back to Login Page -->
                            <a href="{{ route('login') }}" class="primary-color">Back to Login Page</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
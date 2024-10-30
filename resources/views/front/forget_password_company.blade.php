@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->forget_password_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->forget_password_page_meta_description }}@endsection

@section('main_content')
<!-- Top Banner Section for Forget Password Page -->
<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_forget_password) }}')">
    <div class="bg"></div> <!-- Background overlay for visual effect -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Dynamic heading for Forget Password page -->
                <h2>{{ $other_page_item->forget_password_page_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section for Forget Password -->
<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <!-- Forget Password Form -->
                <div class="login-form">
                    <!-- Form to submit the email for password recovery -->
                    <form action="{{ route('company_forget_password_submit') }}" method="post">
                        @csrf
                        <!-- CSRF token for form security -->
                        <div class="mb-3">
                            <!-- Input field for email address -->
                            <label for="" class="form-label">Email Address</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <!-- Submit button to trigger password recovery -->
                            <button type="submit" class="btn btn-primary bg-website">Submit</button>
                            <!-- Link to go back to the login page -->
                            <a href="{{ route('login') }}" class="primary-color">Back to Login Page</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
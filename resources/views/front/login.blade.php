@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->login_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->login_page_meta_description }}@endsection

@section('main_content')
<div class="page-top" style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_login) }}')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Dynamic heading for the login page -->
                <h2>{{ $other_page_item->login_page_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-form">

                    <!-- Tabs for candidate and company login forms -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <!-- Candidate Login Tab -->
                        <li class="nav-item" role="presentation">
                            <!-- Candidate tab is active by default -->
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <i class="far fa-user"></i> Candidate
                            </button>
                        </li>

                        <!-- Company Login Tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">
                                <i class="fas fa-briefcase"></i> Company
                            </button>
                        </li>
                    </ul>

                    <!-- Tab content for both forms -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Candidate Login Form -->
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="{{ route('candidate_login_submit') }}" method="post">
                                @csrf
                                <!-- CSRF token for form protection -->

                                <!-- Username Field -->
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username">
                                </div>

                                <!-- Password Field -->
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>

                                <!-- Login Button and Forget Password Link -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary bg-website">Login</button>
                                    <!-- Link to candidate password recovery -->
                                    <a href="{{ route('candidate_forget_password') }}" class="primary-color">
                                        Forget Password?
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Company Login Form -->
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                            <form action="{{ route('company_login_submit') }}" method="post">
                                @csrf
                                <!-- CSRF token for form protection -->

                                <!-- Username Field -->
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username">
                                </div>

                                <!-- Password Field -->
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>

                                <!-- Login Button and Forget Password Link -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary bg-website">Login</button>
                                    <!-- Link to company password recovery -->
                                    <a href="{{ route('company_forget_password') }}" class="primary-color">
                                        Forget Password?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Signup link for users who don't have an account -->
                    <div class="mb-3">
                        <a href="{{ route('signup') }}" class="primary-color">
                            Don't have an account? Create Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
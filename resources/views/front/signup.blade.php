@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->signup_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->signup_page_meta_description }}@endsection

@section('main_content')
<div class="page-top" style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_signup) }}')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Dynamic heading for the signup page -->
                <h2>{{ $other_page_item->signup_page_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-form">

                    <!-- Bootstrap tabs for candidate and company signup forms -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <!-- Candidate tab with active class to show the form by default -->
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <i class="far fa-user"></i> Candidate
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <!-- Company tab -->
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">
                                <i class="fas fa-briefcase"></i> Company
                            </button>
                        </li>
                    </ul>

                    <!-- Tab content for both forms -->
                    <div class="tab-content" id="pills-tabContent">

                        <!-- Candidate Signup Form -->
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="{{ route('candidate_signup_submit') }}" method="post" onsubmit="showLoader()">
                                @csrf
                                <!-- CSRF token for form protection -->

                                <!-- Candidate Name Field -->
                                <div class="mb-3">
                                    <label class="form-label">Candidate Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        required>
                                    <!-- Display validation error for name field 
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Candidate Username Field -->
                                <div class="mb-3">
                                    <label class="form-label">Username *</label>
                                    <input type="text" class="form-control" name="username"
                                        value="{{ old('username') }}" required minlength="3" maxlength="30">
                                    <!-- Display validation error for username field 
                                    @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Candidate Email Field -->
                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        required>
                                    <!-- Display validation error for email field 
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Candidate Password Field with Strength Indicator -->
                                <div class="mb-3">
                                    <label class="form-label">Password *</label>
                                    <input type="password" class="form-control" id="candidate-password" name="password"
                                        oninput="checkPasswordStrength(this.value, 'candidate')" required
                                        autocomplete="off">

                                    <!-- Password strength progress bar -->
                                    <div class="progress mt-2">
                                        <div id="candidate-password-strength-bar" class="progress-bar"
                                            role="progressbar" style="width: 0;"></div>
                                    </div>
                                    <small id="candidate-password-strength-text" class="text-muted"></small>

                                    <!-- Display validation error for password field 
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Retype Password Field -->
                                <div class="mb-3">
                                    <label class="form-label">Retype Password *</label>
                                    <input type="password" class="form-control" name="retype_password" required
                                        autocomplete="off">
                                    <!-- Display validation error for retype_password field
                                    @error('retype_password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror -->
                                </div>

                                <!-- Submit Button with Loading Spinner -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary bg-website">
                                        Create Account
                                        <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Company Signup Form -->
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                            <form action="{{ route('company_signup_submit') }}" method="post" onsubmit="showLoader()">
                                @csrf
                                <!-- CSRF token for form protection -->

                                <!-- Company Name Field -->
                                <div class="mb-3">
                                    <label class="form-label">Company Name *</label>
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ old('company_name') }}" required>
                                    <!-- Display validation error for company_name field 
                                    @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Contact Person Name Field -->
                                <div class="mb-3">
                                    <label class="form-label">Contact Person Name *</label>
                                    <input type="text" class="form-control" name="person_name"
                                        value="{{ old('person_name') }}" required>
                                    <!-- Display validation error for person_name field 
                                    @error('person_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Company Username Field -->
                                <div class="mb-3">
                                    <label class="form-label">Username *</label>
                                    <input type="text" class="form-control" name="username"
                                        value="{{ old('username') }}" required minlength="3" maxlength="30">
                                    <!-- Display validation error for username field 
                                    @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Company Email Field -->
                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        required>
                                    <!-- Display validation error for email field 
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Company Password Field with Strength Indicator -->
                                <div class="mb-3">
                                    <label class="form-label">Password *</label>
                                    <input type="password" class="form-control" id="company-password" name="password"
                                        oninput="checkPasswordStrength(this.value, 'company')" required
                                        autocomplete="off">

                                    <!-- Password strength progress bar -->
                                    <div class="progress mt-2">
                                        <div id="company-password-strength-bar" class="progress-bar" role="progressbar"
                                            style="width: 0;"></div>
                                    </div>
                                    <small id="company-password-strength-text" class="text-muted"></small>

                                    <!-- Display validation error for password field 
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Retype Password Field -->
                                <div class="mb-3">
                                    <label class="form-label">Retype Password *</label>
                                    <input type="password" class="form-control" name="retype_password" required
                                        autocomplete="off">
                                    <!-- Display validation error for retype_password field 
                                    @error('retype_password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror-->
                                </div>

                                <!-- Submit Button with Loading Spinner -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary bg-website">
                                        Create Account
                                        <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Link to login for existing users -->
                    <div class="mb-3">
                        <a href="{{ route('login') }}" class="primary-color">Existing User? Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle password strength checking and loading spinner -->
<script>
/**
 * Checks the strength of the entered password and updates the progress bar and text.
 * @param {string} password The entered password.
 * @param {string} type Either 'candidate' or 'company' to differentiate between forms.
 */
function checkPasswordStrength(password, type) {
    let strengthBar = document.getElementById(`${type}-password-strength-bar`);
    let strengthText = document.getElementById(`${type}-password-strength-text`);
    let strength = 0;

    // Password strength rules
    if (password.length >= 8) strength += 20;
    if (password.match(/[a-z]/)) strength += 20;
    if (password.match(/[A-Z]/)) strength += 20;
    if (password.match(/[0-9]/)) strength += 20;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 20;

    // Update progress bar width based on strength
    strengthBar.style.width = strength + "%";

    // Update bar color and text based on strength
    if (strength <= 40) {
        strengthBar.className = "progress-bar bg-danger";
        strengthText.innerText = "Weak";
    } else if (strength <= 60) {
        strengthBar.className = "progress-bar bg-warning";
        strengthText.innerText = "Moderate";
    } else if (strength <= 80) {
        strengthBar.className = "progress-bar bg-info";
        strengthText.innerText = "Strong";
    } else {
        strengthBar.className = "progress-bar bg-success";
        strengthText.innerText = "Very Strong";
    }
}

/**
 * Shows a loading spinner when the form is submitted.
 */
function showLoader() {
    document.getElementById('loader').classList.remove('d-none');
}
</script>

<!-- Optional CSS for styling the progress bar -->
<style>
.progress {
    height: 5px;
}

.progress-bar {
    transition: width 0.5s ease;
}
</style>
@endsection
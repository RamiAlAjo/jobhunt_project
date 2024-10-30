<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Declares the document type and sets the language as English -->

    <meta charset="UTF-8">
    <!-- Specifies UTF-8 character encoding to support a wide range of characters -->

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <!-- Ensures responsive design by setting viewport properties for mobile and other devices -->

    <link rel="icon" type="image/png" href="uploads/favicon.png">
    <!-- Links a favicon to be displayed in the browser tab -->

    <title>Admin Panel</title>
    <!-- Defines the title of the page shown in the browser tab -->

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">
    <!-- Imports the Source Sans Pro font with various weights for styling text -->

    @include('admin.layout.styles')
    <!-- Includes CSS files for styling, using Laravel's Blade directive to incorporate the styles partial -->

    @include('admin.layout.scripts')
    <!-- Includes JavaScript files, using Laravel's Blade directive to incorporate the scripts partial -->

</head>

<body>
    <!-- Starts the body of the HTML document -->

    <div id="app">
        <!-- Wrapper div for the Vue or JavaScript app if applicable -->

        <div class="main-wrapper">
            <!-- Main wrapper for centralizing the page content -->

            <section class="section">
                <!-- Defines a section of the document to logically group content -->

                <div class="container container-login">
                    <!-- Container for the login form with custom styling for layout -->

                    <div class="row">
                        <!-- Bootstrap row for responsive grid layout -->

                        <div
                            class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                            <!-- Responsive column with varying widths depending on screen size, centered using offset classes -->

                            <div class="card card-primary border-box">
                                <!-- Bootstrap card component styled as primary, with an added custom border-box class -->

                                <div class="card-header card-header-auth">
                                    <!-- Card header with authentication-specific styling -->
                                    <h4 class="text-center">Admin Panel Login</h4>
                                    <!-- Title text centered within the card header -->
                                </div>

                                <div class="card-body card-body-auth">
                                    <!-- Card body containing the form with authentication-specific styling -->

                                    @if(session()->get('success'))
                                    <div class="text-success">{{ session()->get('success') }}</div>
                                    <!-- Displays a success message from the session, e.g., for a successful password reset -->
                                    @endif

                                    <form method="POST" action="{{ route('admin_login_submit') }}">
                                        <!-- Form submission using POST to the 'admin_login_submit' route -->

                                        @csrf
                                        <!-- Laravel Blade directive for CSRF token to prevent cross-site request forgery -->

                                        <div class="form-group">
                                            <!-- Group for the email input field -->

                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                name="email" placeholder="Email Address" value="{{ old('email') }}"
                                                autofocus>
                                            <!-- Email input with conditional error class and old input value for repopulation -->

                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            <!-- Displays validation error message for email in red -->
                                            @enderror

                                            @if(session()->get('error'))
                                            <div class="text-danger">{{ session()->get('error') }}</div>
                                            <!-- Displays session error message, e.g., for login failures -->
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <!-- Group for the password input field -->

                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password">
                                            <!-- Password input with conditional error class -->

                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            <!-- Displays validation error message for password in red -->
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <!-- Group for the login button -->

                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                Login
                                            </button>
                                            <!-- Button to submit the form, styled as a large, primary button that spans the full width -->
                                        </div>

                                        <div class="form-group">
                                            <!-- Group for the 'Forget Password?' link -->

                                            <div>
                                                <a href="{{ route('admin_forget_password') }}">
                                                    Forget Password?
                                                </a>
                                                <!-- Link to the password reset page -->
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End of form element -->
                                </div>
                                <!-- End of the card body -->
                            </div>
                            <!-- End of the card component -->
                        </div>
                        <!-- End of responsive column -->
                    </div>
                    <!-- End of row layout -->
                </div>
                <!-- End of container for the login section -->
            </section>
            <!-- End of section -->
        </div>
        <!-- End of main-wrapper -->
    </div>
    <!-- End of app wrapper -->

    @include('admin.layout.scripts_footer')
    <!-- Includes JavaScript footer scripts, using Laravel's Blade directive to incorporate the scripts_footer partial -->

</body>
<!-- End of the body -->

</html>
<!-- End of the HTML document -->
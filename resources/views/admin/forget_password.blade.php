<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Declares the document type and specifies language as English for the HTML document -->

    <meta charset="UTF-8">
    <!-- Sets the character encoding to UTF-8 to support a wide range of characters -->

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <!-- Ensures the page is responsive by setting the viewport width to device width, with scaling adjustments -->

    <link rel="icon" type="image/png" href="uploads/favicon.png">
    <!-- Links a favicon for the webpage, which is an icon displayed in the browser tab -->

    <title>Admin Panel</title>
    <!-- Sets the title of the page displayed in the browser tab -->

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">
    <!-- Links to a Google Font (Source Sans Pro) with specific font weights for styling text -->

    @include('admin.layout.styles')
    <!-- Laravel Blade directive to include the 'styles' partial, which contains CSS files for the admin layout -->

    @include('admin.layout.scripts')
    <!-- Laravel Blade directive to include the 'scripts' partial, containing JavaScript files for the admin layout -->
</head>

<body>
    <!-- The main content of the HTML document starts here -->

    <div id="app">
        <!-- Container for the app’s main content, likely tied to JavaScript functionality -->

        <div class="main-wrapper">
            <!-- Wrapper for the main content section of the page -->

            <section class="section">
                <!-- Defines a section in the document for the login form -->

                <div class="container container-login">
                    <!-- Container for centering and organizing the login form within the page -->

                    <div class="row">
                        <!-- Bootstrap row to create a responsive layout for the login form -->

                        <div
                            class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                            <!-- Bootstrap grid system for responsive layout, adjusting size and alignment on different screen sizes -->

                            <div class="card card-primary border-box">
                                <!-- Bootstrap card component for organizing content, with primary styling and a custom border-box class -->

                                <div class="card-header card-header-auth">
                                    <!-- Card header with a custom class for styling the header specifically for authentication -->
                                    <h4 class="text-center">Reset Password</h4>
                                    <!-- Header text centered in the card header -->
                                </div>

                                <div class="card-body card-body-auth">
                                    <!-- Card body where the form and inputs are placed, with custom styling for authentication -->

                                    <form method="POST" action="{{ route('admin_forget_password_submit') }}">
                                        <!-- Form element with POST method to submit data to the 'admin_forget_password_submit' route -->

                                        @csrf
                                        <!-- Laravel Blade directive for generating a CSRF token to protect against cross-site request forgery -->

                                        <div class="form-group">
                                            <!-- Form group for organizing the email input field -->

                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                name="email" placeholder="Email Address" value="" autofocus>
                                            <!-- Text input field for the email address, with conditional error styling if there are validation errors -->

                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            <!-- Displays validation error message in red if there’s an error with the 'email' input -->
                                            @enderror

                                            @if(session()->get('error'))
                                            <div class="text-danger">{{ session()->get('error') }}</div>
                                            <!-- Displays a session error message in red, e.g., if email submission fails -->
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <!-- Form group for the submit button -->

                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                Send Password Reset Link
                                            </button>
                                            <!-- Button to submit the form, styled as a large, primary button that spans the width of the container -->
                                        </div>

                                        <div class="form-group">
                                            <!-- Form group for the navigation link back to login -->

                                            <div>
                                                <a href="{{ route('admin_login') }}">
                                                    Back to login page
                                                </a>
                                                <!-- Link to navigate back to the login page -->
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End of the form element -->
                                </div>
                                <!-- End of the card body -->
                            </div>
                            <!-- End of the card component -->
                        </div>
                        <!-- End of the responsive column layout -->
                    </div>
                    <!-- End of the row container -->
                </div>
                <!-- End of the container for the login section -->
            </section>
            <!-- End of the section for the login form -->
        </div>
        <!-- End of the main-wrapper for the app content -->
    </div>
    <!-- End of the app container -->

    @include('admin.layout.scripts_footer')
    <!-- Laravel Blade directive to include footer scripts specifically for the admin layout -->

</body>
<!-- End of the body content of the HTML document -->

</html>
<!-- End of the HTML document -->
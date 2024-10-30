<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Purpose: This is the main layout template for the front-end of the website.
         It includes meta tags, CSS and JavaScript file links, and dynamically 
         injects page-specific content into designated sections. -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Description and Title dynamically populated -->
    <meta name="description" content="@yield('seo_meta_description')">
    <title>@yield('seo_title')</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/'.$global_settings_data->favicon) }}" />

    <!-- Include CSS Stylesheets -->
    @include('front.layout.styles')

    <!-- Include JavaScript Files -->
    @include('front.layout.scripts')

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>

    <!-- Top Header Section for Contact Information and Authentication Links -->
    <div class="top">
        <div class="container">
            <div class="row">
                <!-- Left Side: Contact Information -->
                <div class="col-md-6 left-side">
                    <ul>
                        <li class="phone-text">{{ $global_settings_data->top_bar_phone }}</li>
                        <li class="email-text">{{ $global_settings_data->top_bar_email }}</li>
                    </ul>
                </div>
                <!-- Right Side: Authentication Links based on User Role -->
                <div class="col-md-6 right-side">
                    <ul class="right">
                        @if(Auth::guard('company')->check())
                        <!-- Company Dashboard Link if Company User is Authenticated -->
                        <li class="menu">
                            <a href="{{ route('company_dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        @elseif(Auth::guard('candidate')->check())
                        <!-- Candidate Dashboard Link if Candidate User is Authenticated -->
                        <li class="menu">
                            <a href="{{ route('candidate_dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        @else
                        <!-- Login and Sign Up Links for Unauthenticated Users -->
                        <li class="menu">
                            <a href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="menu">
                            <a href="{{ route('signup') }}">
                                <i class="fas fa-user"></i> Sign Up
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Navigation Bar -->
    @include('front.layout.nav')

    <!-- Main Content Section, dynamically populated by each page -->
    @yield('main_content')

    <!-- Footer Section with Navigation Links and Contact Information -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <!-- Footer Links for Candidates -->
                <div class="col-lg-3 col-md-6 footer-column">
                    <div class="item">
                        <h2 class="heading">For Candidates</h2>
                        <ul class="useful-links">
                            <li><a href="{{ route('job_listing') }}">Browse Jobs</a></li>
                            <li><a href="{{ route('candidate_dashboard') }}">Candidate Dashboard</a></li>
                            <li><a href="{{ route('candidate_bookmark_view') }}">Bookmarked Jobs</a></li>
                            <li><a href="{{ route('candidate_applications') }}">Applied Jobs</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Footer Links for Companies -->
                <div class="col-lg-3 col-md- footer-column">
                    <div class="item">
                        <h2 class="heading">For Companies</h2>
                        <ul class="useful-links">
                            <li><a href="{{ route('company_listing') }}">Browse Companies</a></li>
                            <li><a href="{{ route('company_dashboard') }}">Company Dashboard</a></li>
                            <li><a href="{{ route('company_jobs_create') }}">Post New Job</a></li>
                            <li><a href="{{ route('company_candidate_applications') }}">Candidate Applications</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Footer Contact Information -->
                <div class="col-lg-3 col-md-6 footer-column">
                    <div class="item">
                        <h2 class="heading">Contact</h2>
                        <div class="list-item">
                            <div class="left"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="right">{{ $global_settings_data->footer_address }}</div>
                        </div>
                        <div class="list-item">
                            <div class="left"><i class="fas fa-phone"></i></div>
                            <div class="right">{{ $global_settings_data->footer_phone }}</div>
                        </div>
                        <div class="list-item">
                            <div class="left"><i class="fas fa-envelope"></i></div>
                            <div class="right">{{ $global_settings_data->footer_email }}</div>
                        </div>
                        <!-- Social Media Links -->
                        <ul class="social">
                            @if($global_settings_data->facebook) <li><a href="{{ $global_settings_data->facebook }}"
                                    target="_blank"><i class="fab fa-facebook-f"></i></a></li> @endif
                            @if($global_settings_data->twitter) <li><a href="{{ $global_settings_data->twitter }}"
                                    target="_blank"><i class="fab fa-twitter"></i></a></li> @endif
                            @if($global_settings_data->pinterest) <li><a href="{{ $global_settings_data->pinterest }}"
                                    target="_blank"><i class="fab fa-pinterest-p"></i></a></li> @endif
                            @if($global_settings_data->linkedin) <li><a href="{{ $global_settings_data->linkedin }}"
                                    target="_blank"><i class="fab fa-linkedin-in"></i></a></li> @endif
                            @if($global_settings_data->instagram) <li><a href="{{ $global_settings_data->instagram }}"
                                    target="_blank"><i class="fab fa-instagram"></i></a></li> @endif
                        </ul>
                    </div>
                </div>
                <!-- Newsletter Subscription Form -->
                <!--  <div class="col-lg-3 col-md-6 footer-column">
                    <div class="item">
                        <h2 class="heading">Newsletter</h2>
                        <p>To get the latest news from our website, please subscribe here:</p>
                        <form action="{{ route('subscriber_send_email') }}" method="post" class="form_subscribe_ajax">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="email" class="form-control">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Subscribe Now">
                            </div>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Footer Bottom Section with Terms and Privacy Links -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright">
                        {{ $global_settings_data->copyright_text }}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="right">
                        <ul>
                            <li><a href="{{ route('terms') }}">Terms of Use</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll-to-Top Button -->
    <div class="scroll-top">
        <i class="fas fa-angle-up"></i>
    </div>

    <!-- Include Additional Scripts at the Bottom of the Page -->
    @include('front.layout.scripts_bottom')






    <!-- iziToast Notifications for Success and Error Messages -->
    <script>
    /**
     * showToast function to display iziToast notifications
     * @param {string} type - Type of toast ('error' or 'success')
     * @param {string} message - Message to be displayed in the toast
     */
    function showToast(type, message) {
        iziToast[type]({
            title: type === 'error' ? 'Error' : 'Success', // Dynamic title based on the type
            message: message, // The message passed to the function
            position: 'topRight', // Position of the toast (top-right corner)
            timeout: 5000, // Auto close after 5 seconds
            progressBar: true, // Show a progress bar at the bottom of the toast
            closeOnClick: true, // Allow users to close the toast by clicking on it
            icon: type === 'error' ? 'fas fa-exclamation-circle' :
            'fas fa-check-circle', // Different icons for error and success
            transitionIn: 'fadeInDown', // Animation for the toast appearance
        });
    }
    </script>

    <!-- Display error messages from the $errors object, if any -->
    @if($errors->any())
    @foreach($errors->all() as $error)
    <script>
    // Trigger an iziToast error notification for each error in the array
    showToast('error', "{{ addslashes($error) }}"); // Safely escape the error message for JavaScript
    </script>
    @endforeach
    @endif

    <!-- Display a session error message, if present -->
    @if(session('error'))
    <script>
    // Trigger an iziToast error notification with the session error message
    showToast('error', "{{ addslashes(session('error')) }}"); // Escape the message properly
    </script>
    @endif

    <!-- Display a session success message, if present -->
    @if(session('success'))
    <script>
    // Trigger an iziToast success notification with the session success message
    showToast('success', "{{ addslashes(session('success')) }}"); // Escape the message properly
    </script>
    @endif















    <!-- AJAX Newsletter Subscription with jQuery and iziToast Notifications -->
    <script>
    (function($) {
        $(".form_subscribe_ajax").on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error_message, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.code == 2) {
                        $('.email_error').text(data.error_message_2);
                    } else if (data.code == 1) {
                        $(form)[0].reset();
                        iziToast.success({
                            title: '',
                            position: 'topRight',
                            message: data.success_message,
                        });
                    }
                }
            });
        });
    })(jQuery);
    </script>
</body>

</html>
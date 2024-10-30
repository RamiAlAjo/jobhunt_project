<div class="navbar-area" id="stickymenu">
    <!-- Purpose: This navigation bar provides a responsive menu for both mobile and desktop devices.
         It dynamically highlights the active page and includes links to various sections of the site. -->

    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <!-- Brand Logo that links to the homepage -->
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('uploads/'.$global_settings_data->logo) }}" alt="" />
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <!-- Navbar element that collapses for smaller screens -->
            <nav class="navbar navbar-expand-md navbar-light">

                <!-- Brand Logo for desktop view linking to the homepage -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('uploads/'.$global_settings_data->logo) }}" alt="" />
                </a>

                <!-- Collapsible menu for smaller screens -->
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                        <!-- Home Link -->
                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>

                        <!-- Find Jobs Link with active highlighting for job listing pages -->
                        <li class="nav-item {{ Request::is('job-listing') || Request::is('job/*') ? 'active' : '' }}">
                            <a href="{{ route('job_listing') }}" class="nav-link">Find Jobs</a>
                        </li>

                        <!-- Companies Link with active highlighting for company listing pages -->
                        <li
                            class="nav-item {{ Request::is('company-listing') || Request::is('company/*') ? 'active' : '' }}">
                            <a href="{{ route('company_listing') }}" class="nav-link">Companies</a>
                        </li>

                        <!-- Pricing Link -->
                        <li class="nav-item {{ Request::is('pricing') ? 'active' : '' }}">
                            <a href="{{ route('pricing') }}" class="nav-link">Pricing</a>
                        </li>

                        <!-- FAQ Link -->
                        <li class="nav-item {{ Request::is('faq') ? 'active' : '' }}">
                            <a href="{{ route('faq') }}" class="nav-link">FAQ</a>
                        </li>

                        <!-- Blog Link with active highlighting for blog and post pages -->
                        <li class="nav-item {{ Request::is('blog') || Request::is('post/*') ? 'active' : '' }}">
                            <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                        </li>

                        <!-- Contact Link -->
                        <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
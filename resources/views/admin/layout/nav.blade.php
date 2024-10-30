<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <!-- Left side of the navbar: Includes sidebar toggle and search toggle -->
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <!-- Sidebar toggle button -->
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <!-- Search toggle button for mobile view -->
            <li>
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li>
        </ul>
    </form>

    <!-- Right side of the navbar: Includes frontend link and user profile dropdown -->
    <ul class="navbar-nav navbar-right w-100-p justify-content-end">
        <!-- Link to open the frontend of the application -->
        <li class="nav-link">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-warning">Front End (Home)</a>
        </li>

        <!-- User profile dropdown menu -->
        <li class="nav-item dropdown">
            <!-- Dropdown toggle with user profile image and name -->
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img alt="image" src="{{ asset('uploads/'.Auth::guard('admin')->user()->photo) }}"
                    class="rounded-circle-custom">
                <div class="d-sm-none d-lg-inline-block">{{ Auth::guard('admin')->user()->name }}</div>
            </a>
            <!-- Dropdown menu items for profile editing and logout -->
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('admin_profile') }}">
                        <i class="far fa-user"></i> Edit Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin_logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
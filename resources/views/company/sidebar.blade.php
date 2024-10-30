<ul class="list-group list-group-flush">
    <!-- Start of the unordered list with Bootstrap classes for a flush list-group -->

    <li class="list-group-item {{ Request::is('company/dashboard') ? 'active' : '' }}">
        <!-- Dashboard link with a condition to add the 'active' class when the current URL matches 'company/dashboard' -->
        <a href="{{ route('company_dashboard') }}">Dashboard</a>
        <!-- Link to the company dashboard using a named route 'company_dashboard' -->
    </li>

    <li class="list-group-item {{ Request::is('company/make-payment') ? 'active' : '' }}">
        <!-- Make Payment link with an active class when on the make-payment page -->
        <a href="{{ route('company_make_payment') }}">Make Payment</a>
        <!-- Link to the 'Make Payment' page for the company -->
    </li>

    <li class="list-group-item {{ Request::is('company/orders') ? 'active' : '' }}">
        <!-- Orders link with an active class when on the orders page -->
        <a href="{{ route('company_orders') }}">Orders</a>
        <!-- Link to the company orders page -->
    </li>

    <li class="list-group-item {{ Request::is('company/create-job') ? 'active' : '' }}">
        <!-- Create Job link with an active class when on the create-job page -->
        <a href="{{ route('company_jobs_create') }}">Create Job</a>
        <!-- Link to the job creation page -->
    </li>

    <li class="list-group-item {{ Request::is('company/jobs') ? 'active' : '' }}">
        <!-- All Jobs link with an active class when on the jobs page -->
        <a href="{{ route('company_jobs') }}">All Jobs</a>
        <!-- Link to the page listing all jobs posted by the company -->
    </li>

    <li class="list-group-item {{ Request::is('company/photos') ? 'active' : '' }}">
        <!-- Photos link with an active class when on the photos page -->
        <a href="{{ route('company_photos') }}">Photos</a>
        <!-- Link to the page for managing company photos -->
    </li>

    <li class="list-group-item {{ Request::is('company/videos') ? 'active' : '' }}">
        <!-- Videos link with an active class when on the videos page -->
        <a href="{{ route('company_videos') }}">Videos</a>
        <!-- Link to the page for managing company videos -->
    </li>

    <li class="list-group-item {{ Request::is('company/candidate-applications') ? 'active' : '' }}">
        <!-- Candidate Applications link with an active class when on the candidate applications page -->
        <a href="{{ route('company_candidate_applications') }}">Candidate Applications</a>
        <!-- Link to the page showing candidate applications -->
    </li>

    <li class="list-group-item {{ Request::is('company/edit-profile') ? 'active' : '' }}">
        <!-- Edit Profile link with an active class when on the edit-profile page -->
        <a href="{{ route('company_edit_profile') }}">Edit Profile</a>
        <!-- Link to the company profile editing page -->
    </li>

    <li class="list-group-item {{ Request::is('company/edit-password') ? 'active' : '' }}">
        <!-- Edit Password link with an active class when on the edit-password page -->
        <a href="{{ route('company_edit_password') }}">Edit Password</a>
        <!-- Link to the password editing page -->
    </li>

    <li class="list-group-item">
        <!-- Logout link -->
        <a href="{{ route('company_logout') }}">Logout</a>
        <!-- Link to log out the company user -->
    </li>
</ul>
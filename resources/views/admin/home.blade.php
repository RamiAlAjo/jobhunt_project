@extends('admin.layout.app')
<!-- Extends the 'app' layout from 'admin.layout' for the dashboard page, providing the base structure and styling -->

@section('heading', 'Dashboard')
<!-- Sets the heading section content to 'Dashboard' for displaying on the page -->

@section('main_content')
<!-- Starts the 'main_content' section, where the main dashboard content is placed -->

<div class="row">
    <!-- Creates a Bootstrap row to structure the content in a responsive grid layout -->

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <!-- Defines a column with different width adjustments for various screen sizes (lg, md, sm, and xs) -->

        <div class="card card-statistic-1">
            <!-- A Bootstrap card component styled with a custom class 'card-statistic-1' for dashboard statistics -->

            <div class="card-icon bg-primary">
                <!-- Container for the card icon, with a background color indicating primary content -->

                <i class="far fa-user"></i>
                <!-- Font Awesome icon representing 'user', indicating the statistic relates to users or companies -->
            </div>

            <div class="card-wrap">
                <!-- Wrapper for card content, which includes header and body sections -->

                <div class="card-header">
                    <h4>Total Companies</h4>
                    <!-- Header indicating the statistic type (Total Companies) -->
                </div>

                <div class="card-body">
                    {{ $total_companies }}
                    <!-- Body displaying the dynamic value for total companies, passed from the controller -->
                </div>
            </div>
        </div>
    </div>

    <!-- Repeats the column layout with similar structure but different icons, colors, and content for Total Candidates -->
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <!-- Background color changed to 'danger' for different visual emphasis -->

                <i class="fas fa-book-open"></i>
                <!-- Icon for 'book-open' suggesting the statistic relates to candidates -->
            </div>

            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Candidates</h4>
                    <!-- Header indicating the statistic type (Total Candidates) -->
                </div>

                <div class="card-body">
                    {{ $total_candidates }}
                    <!-- Body displaying the dynamic value for total candidates -->
                </div>
            </div>
        </div>
    </div>

    <!-- Repeats the column layout with different icon and color for Total Jobs -->
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <!-- Background color changed to 'warning' for different visual emphasis -->

                <i class="fas fa-bullhorn"></i>
                <!-- Icon for 'bullhorn' indicating the statistic relates to jobs -->
            </div>

            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Jobs</h4>
                    <!-- Header indicating the statistic type (Total Jobs) -->
                </div>

                <div class="card-body">
                    {{ $total_jobs }}
                    <!-- Body displaying the dynamic value for total jobs -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of the row container holding the statistics cards -->
@endsection
<!-- Ends the 'main_content' section -->
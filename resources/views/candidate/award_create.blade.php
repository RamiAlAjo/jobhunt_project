@extends('front.layout.app')

@section('main_content')

<!-- Top Banner Section for Add Award Page -->
<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <div class="bg"></div> <!-- Background overlay for visual enhancement -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Heading (Add Award) -->
                <h2>Add Award</h2>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="page-content user-panel">
    <div class="container">
        <div class="row">

            <!-- Left Sidebar for Candidate Navigation -->
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    <!-- Include the candidate sidebar for navigation links -->
                    @include('candidate.sidebar')
                </div>
            </div>

            <!-- Right Section: Add Award Form -->
            <div class="col-lg-9 col-md-12">
                <!-- Link to view all awards (Button) -->
                <a href="{{ route('candidate_award') }}" class="btn btn-primary btn-sm mb-2">
                    <i class="fas fa-plus"></i> See All
                </a>

                <!-- Add Award Form -->
                <form action="{{ route('candidate_award_store') }}" method="post">
                    @csrf
                    <!-- CSRF token for form security -->

                    <div class="row">
                        <!-- Award Title Input -->
                        <div class="col-md-12 mb-3">
                            <label for="">Title *</label>
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>

                        <!-- Award Description Textarea -->
                        <div class="col-md-12 mb-3">
                            <label for="">Description *</label>
                            <div class="form-group">
                                <textarea name="description" class="form-control h-100" cols="30" rows="10"
                                    required></textarea>
                            </div>
                        </div>

                        <!-- Award Date Input -->
                        <div class="col-md-12 mb-3">
                            <label for="">Date *</label>
                            <div class="form-group">
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </div> <!-- End of Row -->

                </form> <!-- End of Add Award Form -->

            </div> <!-- End of Right Section -->
        </div> <!-- End of Row -->
    </div> <!-- End of Container -->
</div>

@endsection
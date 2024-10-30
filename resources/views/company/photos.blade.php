@extends('front.layout.app')
<!-- Extend the main layout of the front end application -->

@section('main_content')
<!-- Define the section where the main content will be rendered -->

<!-- Page top section with background image -->
<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Page title -->
                <h2>Photos</h2>
            </div>
        </div>
    </div>
</div>

<!-- Main content for the user panel -->
<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <!-- Sidebar section for company, with responsive column layout -->
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    <!-- Include the company sidebar, which is a separate view file -->
                    @include('company.sidebar')
                </div>
            </div>

            <!-- Main content section where the photos are displayed and uploaded -->
            <div class="col-lg-9 col-md-12">
                <!-- Section to add a new photo -->
                <h4>Add Photo</h4>
                <!-- Form to submit a new photo -->
                <form action="{{ route('company_photos_submit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- CSRF token for security -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <!-- File input for the photo -->
                                <input type="file" name="photo">
                            </div>
                        </div>
                    </div>
                    <!-- Submit button for the form -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
                        </div>
                    </div>
                </form>

                <!-- Section displaying existing photos -->
                <h4 class="mt-4">Existing Photos</h4>
                <div class="photo-all">
                    <!-- If no photos exist, show a message -->
                    @if($photos->count() == 0)
                    <div class="row">
                        <div class="col-md-12 text-danger">
                            No Photo is Found
                        </div>
                    </div>
                    @endif
                    <!-- Display each photo in a grid layout -->
                    <div class="row">
                        @foreach($photos as $item)
                        <!-- Loop through the photos -->
                        <div class="col-md-6 col-lg-3">
                            <div class="item mb-1">
                                <!-- Link to open the image in a lightbox using magnific popup -->
                                <a href="{{ asset('uploads/'.$item->photo) }}" class="magnific">
                                    <!-- Display the photo -->
                                    <img src="{{ asset('uploads/'.$item->photo) }}" alt="company photos">
                                    <div class="icon">
                                        <i class="fas fa-plus"></i> <!-- Icon for expanding the image -->
                                    </div>
                                    <div class="bg"></div>
                                </a>
                            </div>
                            <!-- Button to delete the photo -->
                            <a href="{{ route('company_photos_delete', $item->id) }}" class="btn btn-danger btn-sm mb-4"
                                onClick="return confirm('Are you sure?');">Delete</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of the main content section -->
@extends('front.layout.app')
<!-- Extends the main front-end layout, which includes shared elements like the header and footer -->

@section('main_content')
<!-- Defines the main content section for the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <!-- Page banner with background image specific to the company panel -->
    <div class="bg"></div>
    <!-- Background overlay for the banner -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Videos</h2>
                <!-- Page title indicating this is the "Videos" section -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content area with specific styling for the user panel -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('company.sidebar')
                    <!-- Includes the sidebar for company navigation options -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content section displaying video management -->

                <h4>Add Video</h4>
                <!-- Form to add a new video -->
                <form action="{{ route('company_videos_submit') }}" method="post">
                    @csrf
                    <!-- CSRF token for form security -->

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <input type="text" name="video_id" class="form-control" placeholder="Enter Video Code">
                                <!-- Input field for video code (YouTube video ID) -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
                            <!-- Submit button to add the video -->
                        </div>
                    </div>
                </form>

                <h4 class="mt-4">Existing Videos</h4>
                <!-- Section title for displaying existing videos -->

                <div class="video-all">
                    @if($videos->count() == 0)
                    <!-- If there are no videos, display a message -->
                    <div class="row">
                        <div class="col-md-12 text-danger">
                            No Video is Found
                            <!-- Message shown when no videos are available -->
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <!-- Loop through each video item to display as a thumbnail -->
                        @foreach($videos as $item)
                        <div class="col-md-6 col-lg-3">
                            <!-- Container for each video item -->

                            <div class="item mb-1">
                                <a class="video-button" href="http://www.youtube.com/watch?v={{ $item->video_id }}">
                                    <!-- Link to open the video on YouTube -->

                                    <img src="http://img.youtube.com/vi/{{ $item->video_id }}/0.jpg" alt="">
                                    <!-- Thumbnail of the YouTube video -->

                                    <div class="icon">
                                        <i class="far fa-play-circle"></i>
                                        <!-- Play icon overlay on the thumbnail -->
                                    </div>
                                    <div class="bg"></div>
                                    <!-- Background overlay on the video thumbnail -->
                                </a>
                            </div>

                            <a href="{{ route('company_videos_delete',$item->id) }}" class="btn btn-danger btn-sm mb-4"
                                onClick="return confirm('Are you sure?');">
                                <!-- Link to delete the video with a confirmation prompt -->
                                Delete
                            </a>
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
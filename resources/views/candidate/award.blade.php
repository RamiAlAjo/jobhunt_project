@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall page structure for the front end -->

@section('main_content')
<!-- Defines the main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <!-- Banner section with a background image specific to the candidate panel, dynamically loaded from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Awards</h2>
                <!-- Page heading title displayed prominently over the banner -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content section for the user panel layout -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('candidate.sidebar')
                    <!-- Includes the candidate sidebar, which likely contains navigation links relevant to the candidate's profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area where the awards table and controls are displayed -->

                <a href="{{ route('candidate_award_create') }}" class="btn btn-primary btn-sm mb-2">
                    <i class="fas fa-plus"></i> Add Item
                </a>
                <!-- Button to add a new award, linking to the 'candidate_award_create' route -->

                @if(!$awards->count())
                <div class="text-danger">No data found</div>
                <!-- Message displayed if there are no awards found for the candidate -->
                @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for the awards data -->
                                <th>SL</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th class="w-100">Action</th>
                            </tr>

                            @foreach($awards as $item)
                            <!-- Loop through each award item for the candidate -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Sequential number for the current item, using Blade's $loop->iteration -->

                                <td>{{ $item->title }}</td>
                                <!-- Award title -->

                                <td>{{ $item->description }}</td>
                                <!-- Brief description of the award -->

                                <td>{{ $item->date }}</td>
                                <!-- Date when the award was received -->

                                <td>
                                    <!-- Action buttons for editing and deleting each award -->
                                    <a href="{{ route('candidate_award_edit', $item->id) }}"
                                        class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Edit button linking to the 'candidate_award_edit' route with the award ID -->

                                    <a href="{{ route('candidate_award_delete', $item->id) }}"
                                        class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <!-- Delete button linking to the 'candidate_award_delete' route with the award ID and a JavaScript confirmation prompt -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying awards data -->
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
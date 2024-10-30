@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall page structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_candidate_panel) }}')">
    <!-- Banner section with a background image specific to the candidate panel, dynamically loaded from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Skills</h2>
                <!-- Page heading, displaying "Skills" prominently over the banner image -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content section specific to the user panel layout -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('candidate.sidebar')
                    <!-- Includes the candidate sidebar, which likely contains navigation options relevant to the candidate's profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area for displaying and managing skills -->

                <a href="{{ route('candidate_skill_create') }}" class="btn btn-primary btn-sm mb-2">
                    <i class="fas fa-plus"></i> Add Item
                </a>
                <!-- Button to add a new skill, linking to the 'candidate_skill_create' route -->

                @if(!$skills->count())
                <div class="text-danger">No data found</div>
                <!-- Message displayed if there are no skills found for the candidate -->
                @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Table headers for the skills data -->
                                <th>SL</th>
                                <th>Skill Name</th>
                                <th>Percentage</th>
                                <th class="w-100">Action</th>
                            </tr>

                            @foreach($skills as $item)
                            <!-- Loop through each skill item for the candidate -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Displays the sequential number for the current skill entry, using Blade's $loop->iteration -->

                                <td>{{ $item->name }}</td>
                                <!-- Displays the name of the skill -->

                                <td>{{ $item->percentage }}</td>
                                <!-- Displays the proficiency percentage for the skill -->

                                <td>
                                    <!-- Action buttons for editing and deleting each skill -->
                                    <a href="{{ route('candidate_skill_edit', $item->id) }}"
                                        class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Edit button linking to the 'candidate_skill_edit' route with the skill ID -->

                                    <a href="{{ route('candidate_skill_delete', $item->id) }}"
                                        class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <!-- Delete button linking to the 'candidate_skill_delete' route with the skill ID and a JavaScript confirmation prompt -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of table for displaying skills data -->
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
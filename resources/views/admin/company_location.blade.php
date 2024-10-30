@extends('admin.layout.app')

@section('heading', 'Company Locations')

@section('button')
<div>
    <!-- Button to navigate to the "Add New" company location form -->
    <a href="{{ route('admin_company_location_create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Responsive table wrapper -->
                    <div class="table-responsive">
                        <!-- Company locations table -->
                        <table class="table table-bordered" id="example1">
                            <!-- Table header -->
                            <thead>
                                <tr>
                                    <th>SL</th> <!-- Serial Number Column -->
                                    <th>Name</th> <!-- Company Location Name Column -->
                                    <th>Action</th> <!-- Action Buttons Column -->
                                </tr>
                            </thead>
                            <!-- Table body displaying each location's data -->
                            <tbody>
                                <!-- Loop through the company_locations collection and display each location -->
                                @foreach($company_locations as $item)
                                <tr>
                                    <!-- Display the serial number using loop iteration -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Display the name of the company location -->
                                    <td>{{ $item->name }}</td>
                                    <!-- Action buttons for Edit and Delete -->
                                    <td class="pt_10 pb_10">
                                        <!-- Edit button navigating to the edit form for the current location -->
                                        <a href="{{ route('admin_company_location_edit', $item->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Delete button with a confirmation prompt -->
                                        <a href="{{ route('admin_company_location_delete', $item->id) }}"
                                            class="btn btn-danger btn-sm"
                                            onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- .table-responsive -->
                </div> <!-- .card-body -->
            </div> <!-- .card -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</div> <!-- .section-body -->
@endsection
@extends('admin.layout.app')

@section('heading', 'Company Sizes')

@section('button')
<div>
    <!-- Button to add a new company size -->
    <a href="{{ route('admin_company_size_create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card container for the list of company sizes -->
            <div class="card">
                <div class="card-body">
                    <!-- Responsive table to display company sizes -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <!-- Table header defining columns for the data -->
                            <thead>
                                <tr>
                                    <th>SL</th> <!-- Serial Number -->
                                    <th>Name</th> <!-- Company Size Name -->
                                    <th>Action</th> <!-- Action buttons (Edit/Delete) -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through each company size and create a table row for each -->
                                @foreach($company_sizes as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> <!-- Serial number using the loop index -->
                                    <td>{{ $item->name }}</td> <!-- Company size name -->
                                    <td class="pt_10 pb_10">
                                        <!-- Edit button linking to the edit page for this company size -->
                                        <a href="{{ route('admin_company_size_edit', $item->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Delete button with a confirmation prompt -->
                                        <a href="{{ route('admin_company_size_delete', $item->id) }}"
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
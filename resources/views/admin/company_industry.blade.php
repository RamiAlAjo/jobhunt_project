@extends('admin.layout.app')

@section('heading', 'Company Industries')

@section('button')
<div>
    <!-- Button to add a new company industry -->
    <a href="{{ route('admin_company_industry_create') }}" class="btn btn-primary">
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
                    <!-- Responsive table to display company industries -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <!-- Table headers -->
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through each company industry and display in the table -->
                                @foreach($company_industries as $item)
                                <tr>
                                    <!-- Display the serial number of each item -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Display the name of the company industry -->
                                    <td>{{ $item->name }}</td>
                                    <td class="pt_10 pb_10">
                                        <!-- Edit button with link to the industry edit form -->
                                        <a href="{{ route('admin_company_industry_edit', $item->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Delete button with a confirmation prompt -->
                                        <a href="{{ route('admin_company_industry_delete', $item->id) }}"
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
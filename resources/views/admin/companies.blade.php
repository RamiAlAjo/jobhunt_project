@extends('admin.layout.app')

@section('heading', 'Companies')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Main card containing the company's list -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Table displaying the list of companies -->
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <!-- Table headers for displaying company details -->
                                    <th>SL</th>
                                    <th>Company Name</th>
                                    <th>Person Name</th>
                                    <th>Username</th>
                                    <th>Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through each company and display its details -->
                                @foreach($companies as $item)
                                <tr>
                                    <!-- Serial number based on loop iteration -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Company name -->
                                    <td>{{ $item->company_name }}</td>
                                    <!-- Person's name associated with the company -->
                                    <td>{{ $item->person_name }}</td>
                                    <!-- Company username -->
                                    <td>{{ $item->username }}</td>
                                    <!-- Detail buttons linking to company details and jobs -->
                                    <td>
                                        <!-- Link to view detailed information about the company -->
                                        <a href="{{ route('admin_companies_detail', $item->id) }}"
                                            class="badge bg-primary text-white w-100 mb-1">Detail</a>
                                        <!-- Link to view jobs posted by the company -->
                                        <a href="{{ route('admin_companies_jobs', $item->id) }}"
                                            class="badge bg-primary text-white w-100 mb-1">Jobs</a>
                                    </td>
                                    <!-- Action button to delete the company with a confirmation prompt -->
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin_companies_delete', $item->id) }}"
                                            class="btn btn-danger btn-sm"
                                            onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
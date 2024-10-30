@extends('admin.layout.app')

@section('heading', 'Candidates')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Main card containing the candidates table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Data table for listing candidates -->
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Username</th>
                                    <th>Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through the candidates data and display each candidate's information -->
                                @foreach($candidates as $item)
                                <tr>
                                    <!-- Serial number for each candidate entry -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Displaying candidate's name -->
                                    <td>{{ $item->name }}</td>
                                    <!-- Displaying candidate's email -->
                                    <td>{{ $item->email }}</td>
                                    <!-- Displaying candidate's phone -->
                                    <td>{{ $item->phone }}</td>
                                    <!-- Displaying candidate's username -->
                                    <td>{{ $item->username }}</td>
                                    <!-- Detail and Applied Jobs buttons, linking to their respective candidate-specific routes -->
                                    <td>
                                        <a href="{{ route('admin_candidates_detail',$item->id) }}"
                                            class="badge bg-primary text-white w-100 mb-1">Detail</a>
                                        <a href="{{ route('admin_candidates_applied_jobs',$item->id) }}"
                                            class="badge bg-primary text-white w-100 mb-1">Applied Jobs</a>
                                    </td>
                                    <!-- Delete button to remove the candidate; includes a confirmation prompt to prevent accidental deletions -->
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin_candidates_delete',$item->id) }}"
                                            class="btn btn-danger btn-sm"
                                            onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End of the table containing the candidates list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
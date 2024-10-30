@extends('admin.layout.app')

@section('heading', 'Jobs of company: '.$companies_detail->company_name)

@section('button')
<div>
    <!-- Button to navigate back to the main companies page -->
    <a href="{{ route('admin_companies') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Previous</a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Main card containing the company's job listings -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Table displaying the company's jobs -->
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <!-- Table headers to display job details -->
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Is Featured?</th>
                                    <th>Job Detail</th>
                                    <th>Applicants</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through each job and display its details -->
                                @foreach($companies_jobs as $item)
                                <tr>
                                    <!-- Serial number based on loop iteration -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Job title -->
                                    <td>{{ $item->title }}</td>
                                    <!-- Job category using relationship to fetch category name -->
                                    <td>{{ $item->rJobCategory->name }}</td>
                                    <!-- Job location using relationship to fetch location name -->
                                    <td>{{ $item->rJobLocation->name }}</td>
                                    <!-- Job featured status displayed as badge -->
                                    <td>
                                        @if($item->is_featured == 1)
                                        <span class="badge bg-success">Featured</span>
                                        @else
                                        <span class="badge bg-danger">Not Featured</span>
                                        @endif
                                    </td>
                                    <!-- Link to the job detail page -->
                                    <td>
                                        <a href="{{ route('job',$item->id) }}"
                                            class="badge bg-primary text-white">Detail</a>
                                    </td>
                                    <!-- Link to view applicants for the job -->
                                    <td>
                                        <a href="{{ route('admin_companies_applicants',$item->id) }}"
                                            class="badge bg-primary text-white">Applicants</a>
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
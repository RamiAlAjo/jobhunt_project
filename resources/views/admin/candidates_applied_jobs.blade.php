@extends('admin.layout.app')

@section('heading', 'Candidates Applied Jobs')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card containing the table of job applications -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Table to display all applied jobs -->
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Cover Letter</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Initialize the iteration counter -->
                                @php $i=0; @endphp
                                <!-- Loop through each application item -->
                                @foreach($applications as $item)
                                @php $i++; @endphp
                                <tr>
                                    <!-- Serial Number (iteration count) -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Job Title linked from the related Job model -->
                                    <td>{{ $item->rJob->title }}</td>
                                    <!-- Company Name linked from the related Job and Company models -->
                                    <td>{{ $item->rJob->rCompany->company_name }}</td>
                                    <!-- Display Status with a badge color based on the application status -->
                                    <td>
                                        @if($item->status == 'Applied')
                                        @php $color = 'primary'; @endphp
                                        @elseif($item->status == 'Approved')
                                        @php $color = 'success'; @endphp
                                        @elseif($item->status == 'Rejected')
                                        @php $color = 'danger'; @endphp
                                        @endif
                                        <div class="badge bg-{{ $color }}">
                                            {{ $item->status }}
                                        </div>
                                    </td>
                                    <!-- Button to open modal for viewing Cover Letter -->
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $i }}">Cover Letter</a>
                                    </td>
                                    <!-- Detail button that links to the job details page -->
                                    <td>
                                        <a href="{{ route('job',$item->rJob->id) }}"
                                            class="btn btn-primary btn-sm text-white"><i class="fas fa-eye"></i></a>

                                        <!-- Modal to display the Cover Letter content -->
                                        <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cover Letter
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <!-- Modal Body with Cover Letter content, formatted with nl2br for line breaks -->
                                                    <div class="modal-body">
                                                        {!! nl2br($item->cover_letter) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
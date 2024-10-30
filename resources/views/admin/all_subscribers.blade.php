@extends('admin.layout.app')

@section('heading', 'All Subscribers')

@section('button')
<div>
    <!-- Button to send an email to all subscribers -->
    <a href="{{ route('admin_subscribers_send_email') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Send Email to All
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card containing the table of subscribers -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Table to display all subscribers -->
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through each subscriber item -->
                                @foreach($subscribers as $item)
                                <tr>
                                    <!-- Serial Number (iteration count) -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Subscriber Email -->
                                    <td>{{ $item->email }}</td>
                                    <!-- Delete button with confirmation -->
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin_subscriber_delete',$item->id) }}"
                                            class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">
                                            Delete
                                        </a>
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
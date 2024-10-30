@extends('admin.layout.app')

@section('heading', 'FAQs')

@section('button')
<div>
    <!-- Button to navigate to the 'Add New FAQ' page -->
    <a href="{{ route('admin_faq_create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card container to display the FAQ list -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Data table to list all FAQs with options to edit or delete -->
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Question</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faqs as $item)
                                <tr>
                                    <!-- Serial number to display the current iteration count of the loop -->
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- Displaying the question from the FAQ item -->
                                    <td>{{ $item->question }}</td>
                                    <td class="pt_10 pb_10">
                                        <!-- Edit button: navigates to the FAQ edit page for the selected item -->
                                        <a href="{{ route('admin_faq_edit', $item->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Delete button: confirms before deletion, removes the selected FAQ -->
                                        <a href="{{ route('admin_faq_delete', $item->id) }}"
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
@extends('admin.layout.app')

@section('heading', 'Create Company Size')

@section('button')
<div>
    <!-- Button to navigate back to the list of all company sizes -->
    <a href="{{ route('admin_company_size') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> View All
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card to hold the form for creating a company size -->
            <div class="card">
                <div class="card-body">
                    <!-- Form for creating a new company size, with CSRF token for security -->
                    <form action="{{ route('admin_company_size_store') }}" method="post">
                        @csrf
                        <!-- Laravel CSRF protection token -->
                        <!-- Input field for the company size name -->
                        <div class="form-group mb-3">
                            <label>Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <!-- Submit button to save the new company size -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div> <!-- .card-body -->
            </div> <!-- .card -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</div> <!-- .section-body -->
@endsection
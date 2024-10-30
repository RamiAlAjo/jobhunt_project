@extends('admin.layout.app')

@section('heading', 'Create Company Location')

@section('button')
<div>
    <!-- Button to navigate back to the list of all company locations -->
    <a href="{{ route('admin_company_location') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> View All
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Form to create a new company location entry -->
                    <form action="{{ route('admin_company_location_store') }}" method="post">
                        @csrf
                        <!-- CSRF protection token for secure form submission -->

                        <!-- Form Group for Location Name -->
                        <div class="form-group mb-3">
                            <label>Name *</label>
                            <!-- Input field for the name of the company location -->
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <!-- Submit button to create the location -->
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
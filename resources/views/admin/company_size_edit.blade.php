@extends('admin.layout.app')

@section('heading', 'Edit Company Size')

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
            <!-- Card container for the form -->
            <div class="card">
                <div class="card-body">
                    <!-- Form for updating an existing company size, with CSRF protection -->
                    <form action="{{ route('admin_company_size_update',$company_size_single->id) }}" method="post">
                        @csrf
                        <!-- Laravel's CSRF protection directive -->
                        <!-- Input field for editing the company size name -->
                        <div class="form-group mb-3">
                            <label>Name *</label>
                            <!-- Displaying the current value of the company size to be edited -->
                            <input type="text" class="form-control" name="name" value="{{ $company_size_single->name }}"
                                required>
                        </div>
                        <!-- Submit button to save the updated company size information -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div> <!-- .card-body -->
            </div> <!-- .card -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</div> <!-- .section-body -->
@endsection
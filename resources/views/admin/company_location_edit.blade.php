@extends('admin.layout.app')

@section('heading', 'Edit Company Location')

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
                    <!-- Form to update the existing company location entry -->
                    <form action="{{ route('admin_company_location_update',$company_location_single->id) }}"
                        method="post">
                        @csrf
                        <!-- CSRF protection token for secure form submission -->

                        <!-- Form Group for Location Name -->
                        <div class="form-group mb-3">
                            <label>Name *</label>
                            <!-- Input field pre-filled with the current location name -->
                            <input type="text" class="form-control" name="name"
                                value="{{ $company_location_single->name }}" required>
                        </div>

                        <!-- Submit button to update the location -->
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
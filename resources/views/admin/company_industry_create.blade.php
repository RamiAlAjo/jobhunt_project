@extends('admin.layout.app')

@section('heading', 'Create Company Industry')

@section('button')
<div>
    <!-- Button to navigate back to the full list of company industries -->
    <a href="{{ route('admin_company_industry') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> View All
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card container for form styling and layout -->
            <div class="card">
                <div class="card-body">
                    <!-- Form to submit new company industry data -->
                    <form action="{{ route('admin_company_industry_store') }}" method="post">
                        @csrf
                        <!-- CSRF token for form security -->

                        <!-- Input field for the name of the new industry -->
                        <div class="form-group mb-3">
                            <label>Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <!-- Submit button to save the new industry -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
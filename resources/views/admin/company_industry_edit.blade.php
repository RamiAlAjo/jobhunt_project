@extends('admin.layout.app')

@section('heading', 'Edit Company Industry')

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
                    <!-- Form to update the selected company industry -->
                    <form action="{{ route('admin_company_industry_update', $company_industry_single->id) }}"
                        method="post">
                        @csrf
                        <!-- CSRF token for form security -->

                        <!-- Input field for editing the name of the industry -->
                        <div class="form-group mb-3">
                            <label>Name *</label>
                            <!-- Pre-fill the input with the current industry name -->
                            <input type="text" class="form-control" name="name"
                                value="{{ $company_industry_single->name }}" required>
                        </div>

                        <!-- Submit button to save the updated industry details -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
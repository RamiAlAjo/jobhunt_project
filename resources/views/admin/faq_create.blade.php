@extends('admin.layout.app')

@section('heading', 'Create FAQ')

@section('button')
<div>
    <!-- Button to view all FAQs -->
    <a href="{{ route('admin_faq') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> View All
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card container for the FAQ form -->
            <div class="card">
                <div class="card-body">
                    <!-- Form to create a new FAQ entry -->
                    <form action="{{ route('admin_faq_store') }}" method="post">
                        <!-- CSRF token for form security -->
                        @csrf
                        <!-- Input field for the FAQ question -->
                        <div class="form-group mb-3">
                            <label>Question *</label>
                            <input type="text" class="form-control" name="question" required>
                        </div>
                        <!-- Textarea for the FAQ answer -->
                        <div class="form-group mb-3">
                            <label>Answer *</label>
                            <textarea name="answer" class="form-control editor" cols="30" rows="10" required></textarea>
                        </div>
                        <!-- Submit button to save the FAQ -->
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
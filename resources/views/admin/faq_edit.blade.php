@extends('admin.layout.app')

@section('heading', 'Edit FAQ')

@section('button')
<div>
    <!-- Button to go back to the full FAQ list -->
    <a href="{{ route('admin_faq') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> View All
    </a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Card container for the FAQ editing form -->
            <div class="card">
                <div class="card-body">
                    <!-- Form to edit the existing FAQ entry -->
                    <form action="{{ route('admin_faq_update', $faq_single->id) }}" method="post">
                        <!-- CSRF token for form security -->
                        @csrf
                        <!-- Input field for editing the FAQ question -->
                        <div class="form-group mb-3">
                            <label>Question *</label>
                            <input type="text" class="form-control" name="question" value="{{ $faq_single->question }}"
                                required>
                        </div>
                        <!-- Textarea for editing the FAQ answer -->
                        <div class="form-group mb-3">
                            <label>Answer *</label>
                            <textarea name="answer" class="form-control editor" cols="30" rows="10"
                                required>{{ $faq_single->answer }}</textarea>
                        </div>
                        <!-- Submit button to save the edited FAQ -->
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
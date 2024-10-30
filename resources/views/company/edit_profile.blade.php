@extends('front.layout.app')
<!-- Extends the front layout template, which includes shared elements like the header, footer, and overall page structure for the front end -->

@section('main_content')
<!-- Main content section of the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <!-- Banner section with a background image specific to the company panel, dynamically loaded from $global_banner_data -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Profile</h2>
                <!-- Page heading, indicating that this is the Edit Profile page -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content section specific to the user panel layout -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('company.sidebar')
                    <!-- Includes the company sidebar, which likely contains navigation options relevant to the company profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content area for displaying the Edit Profile form -->

                <form action="{{ route('company_edit_profile_update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Form submission to update the company's profile with the route 'company_edit_profile_update' -->

                    <div class="row">
                        <!-- Company Logo Upload -->
                        <div class="col-md-12 mb-3">
                            <label for="">Existing Logo</label>
                            <div class="form-group">
                                @if(Auth::guard('company')->user()->logo == '')
                                <img src="{{ asset('uploads/default_company_logo.jpg') }}" alt="" class="logo">
                                @else
                                <img src="{{ asset('uploads/'.Auth::guard('company')->user()->logo) }}" alt=""
                                    class="logo">
                                @endif
                                <!-- Displays existing logo or a default logo if none is uploaded -->
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Change Logo</label>
                            <div class="form-group">
                                <input type="file" name="logo">
                                <!-- File input for uploading a new logo -->
                            </div>
                        </div>

                        <!-- Profile Fields -->
                        <div class="col-md-6 mb-3">
                            <label for="">Company Name *</label>
                            <div class="form-group">
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ Auth::guard('company')->user()->company_name }}">
                                <!-- Input for company name, pre-filled with the company's current name -->
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Contact Person *</label>
                            <div class="form-group">
                                <input type="text" name="person_name" class="form-control"
                                    value="{{ Auth::guard('company')->user()->person_name }}">
                                <!-- Input for contact person name -->
                            </div>
                        </div>

                        <!-- Other profile details (username, email, phone, address, etc.) -->
                        <div class="col-md-6 mb-3">
                            <label for="">Username *</label>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control"
                                    value="{{ Auth::guard('company')->user()->username }}">
                                <!-- Input for username -->
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Email *</label>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control"
                                    value="{{ Auth::guard('company')->user()->email }}">
                                <!-- Input for email -->
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Phone</label>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control"
                                    value="{{ Auth::guard('company')->user()->phone }}">
                                <!-- Input for phone number -->
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Address</label>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control"
                                    value="{{ Auth::guard('company')->user()->address }}">
                                <!-- Input for address -->
                            </div>
                        </div>

                        <!-- Dropdowns for company location, industry, and size -->
                        <div class="col-md-6 mb-3">
                            <label for="">Company Location *</label>
                            <div class="form-group">
                                <select name="company_location_id" class="form-control select2">
                                    @foreach($company_locations as $item)
                                    <option value="{{ $item->id }}" @if($item->id ==
                                        Auth::guard('company')->user()->company_location_id) selected
                                        @endif>{{ $item->name }}</option>
                                    @endforeach
                                    <!-- Dropdown for selecting company location with current location selected -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Company Industry *</label>
                            <div class="form-group">
                                <select name="company_industry_id" class="form-control select2">
                                    @foreach($company_industries as $item)
                                    <option value="{{ $item->id }}" @if($item->id ==
                                        Auth::guard('company')->user()->company_industry_id) selected
                                        @endif>{{ $item->name }}</option>
                                    @endforeach
                                    <!-- Dropdown for selecting company industry -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Company Size *</label>
                            <div class="form-group">
                                <select name="company_size_id" class="form-control select2">
                                    @foreach($company_sizes as $item)
                                    <option value="{{ $item->id }}" @if($item->id ==
                                        Auth::guard('company')->user()->company_size_id) selected
                                        @endif>{{ $item->name }}</option>
                                    @endforeach
                                    <!-- Dropdown for selecting company size -->
                                </select>
                            </div>
                        </div>

                        <!-- Year Founded -->
                        <div class="col-md-6 mb-3">
                            <label for="">Founded On *</label>
                            <div class="form-group">
                                <select name="founded_on" class="form-control select2">
                                    @for($i = 1900; $i <= date('Y'); $i++) <option value="{{ $i }}"
                                        @if($i==Auth::guard('company')->user()->founded_on) selected @endif>{{ $i }}
                                        </option>
                                        @endfor
                                        <!-- Dropdown for selecting the year the company was founded -->
                                </select>
                            </div>
                        </div>

                        <!-- Company Description -->
                        <div class="col-md-12 mb-3">
                            <label for="">About Company</label>
                            <textarea name="description" class="form-control editor" cols="30"
                                rows="10">{{ Auth::guard('company')->user()->description }}</textarea>
                            <!-- Textarea for company description with a WYSIWYG editor class -->
                        </div>

                        <!-- Opening Hours for each day of the week -->
                        @php
                        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        @endphp

                        @foreach($days as $day)
                        <div class="col-md-6 mb-3">
                            <label for="">Opening Hour ({{ ucfirst($day) }})</label>
                            <div class="form-group">
                                <input type="text" name="oh_{{ $day }}" class="form-control"
                                    value="{{ Auth::guard('company')->user()->{'oh_'.$day} }}">
                                <!-- Input for each day's opening hours -->
                            </div>
                        </div>
                        @endforeach

                        <!-- Social Media Links -->
                        @php
                        $socials = ['facebook', 'twitter', 'linkedin', 'instagram'];
                        @endphp

                        @foreach($socials as $social)
                        <div class="col-md-6 mb-3">
                            <label for="">{{ ucfirst($social) }}</label>
                            <div class="form-group">
                                <input type="text" name="{{ $social }}" class="form-control"
                                    value="{{ Auth::guard('company')->user()->{$social} }}">
                                <!-- Input for each social media link -->
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <!-- Submit button to update profile -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
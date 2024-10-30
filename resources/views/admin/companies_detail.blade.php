@extends('admin.layout.app')

@section('heading', 'Companies Detail')

@section('button')
<div>
    <!-- Button to navigate back to the main companies page -->
    <a href="{{ route('admin_companies') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Previous</a>
</div>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <!-- Main card containing the company's details -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Table displaying company's detailed information -->
                        <table class="table table-bordered table-sm">
                            <!-- Company logo -->
                            <tr>
                                <th class="w_200">Logo</th>
                                <td>
                                    <img src="{{ asset('uploads/'.$companies_detail->logo) }}" alt="" class="w_100">
                                </td>
                            </tr>
                            <!-- Company name -->
                            <tr>
                                <th class="w_200">Company Name</th>
                                <td>{{ $companies_detail->company_name }}</td>
                            </tr>
                            <!-- Company representative's name -->
                            <tr>
                                <th class="w_200">Person Name</th>
                                <td>{{ $companies_detail->person_name }}</td>
                            </tr>
                            <!-- Username -->
                            <tr>
                                <th class="w_200">Username</th>
                                <td>{{ $companies_detail->username }}</td>
                            </tr>
                            <!-- Email address -->
                            <tr>
                                <th class="w_200">Email</th>
                                <td>{{ $companies_detail->email }}</td>
                            </tr>
                            <!-- Phone number -->
                            <tr>
                                <th class="w_200">Phone</th>
                                <td>{{ $companies_detail->phone }}</td>
                            </tr>
                            <!-- Address -->
                            <tr>
                                <th class="w_200">Address</th>
                                <td>{{ $companies_detail->address }}</td>
                            </tr>
                            <!-- Industry information (using a relationship to display) -->
                            <tr>
                                <th class="w_200">Industry</th>
                                <td>{{ $companies_detail->rCompanyIndustry->name }}</td>
                            </tr>
                            <!-- Location information (using a relationship to display) -->
                            <tr>
                                <th class="w_200">Location</th>
                                <td>{{ $companies_detail->rCompanyLocation->name }}</td>
                            </tr>
                            <!-- Company size information -->
                            <tr>
                                <th class="w_200">Size</th>
                                <td>{{ $companies_detail->rCompanySize->name }}</td>
                            </tr>
                            <!-- Year company was founded -->
                            <tr>
                                <th class="w_200">Founded On</th>
                                <td>{{ $companies_detail->founded_on }}</td>
                            </tr>
                            <!-- Website link -->
                            <tr>
                                <th class="w_200">Website</th>
                                <td>{{ $companies_detail->website }}</td>
                            </tr>
                            <!-- Description of the company, rendered with HTML -->
                            <tr>
                                <th class="w_200">Description</th>
                                <td>{!! $companies_detail->description !!}</td>
                            </tr>
                            <!-- Company's opening hours for each day -->
                            <tr>
                                <th class="w_200">Opening Hours</th>
                                <td>
                                    Monday: {{ $companies_detail->oh_mon }}<br>
                                    Tuesday: {{ $companies_detail->oh_tue }}<br>
                                    Wednesday: {{ $companies_detail->oh_wed }}<br>
                                    Thursday: {{ $companies_detail->oh_thu }}<br>
                                    Friday: {{ $companies_detail->oh_fri }}<br>
                                    Saturday: {{ $companies_detail->oh_sat }}<br>
                                    Sunday: {{ $companies_detail->oh_sun }}
                                </td>
                            </tr>
                            <!-- Social media links -->
                            <tr>
                                <th class="w_200">Facebook</th>
                                <td>{{ $companies_detail->facebook }}</td>
                            </tr>
                            <tr>
                                <th class="w_200">Twitter</th>
                                <td>{{ $companies_detail->twitter }}</td>
                            </tr>
                            <tr>
                                <th class="w_200">LinkedIn</th>
                                <td>{{ $companies_detail->linkedin }}</td>
                            </tr>
                            <tr>
                                <th class="w_200">Instagram</th>
                                <td>{{ $companies_detail->instagram }}</td>
                            </tr>
                            <!-- Embedded Google Map with map code -->
                            <tr>
                                <th class="w_200">Google Map</th>
                                <td>{!! $companies_detail->map_code !!}</td>
                            </tr>
                            <!-- Company photos displayed using a loop -->
                            <tr>
                                <th class="w_200">Photos</th>
                                <td>
                                    @foreach($photos as $item)
                                    <img src="{{ asset('uploads/'.$item->photo) }}" alt="" class="w_300">
                                    @endforeach
                                </td>
                            </tr>
                            <!-- Company videos, displayed using embedded YouTube iframes -->
                            <tr>
                                <th class="w_200">Videos</th>
                                <td>
                                    @foreach($videos as $item)
                                    <iframe class="w_300 h_200" width="560" height="315"
                                        src="https://www.youtube.com/embed/{{ $item->video_id }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
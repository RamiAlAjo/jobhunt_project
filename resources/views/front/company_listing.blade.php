@extends('front.layout.app')

@section('seo_title'){{ $other_page_item->company_listing_page_title }}@endsection
@section('seo_meta_description'){{ $other_page_item->company_listing_page_meta_description }}@endsection

@section('main_content')
<!-- 
    Purpose: This section renders the company listing page, which allows users to search and filter companies 
    based on various criteria. It includes a header with a background image, a filter form, 
    and a list of companies that match the search criteria.
-->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_listing) }}')">
    <!-- Top Banner with Background Image -->
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $other_page_item->company_listing_page_heading }}</h2>
                <!-- Displaying the heading for the company listing page -->
            </div>
        </div>
    </div>
</div>

<div class="job-result">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="job-filter">
                    <!-- Filter Form for Company Listings -->
                    <form action="{{ url('company-listing') }}" method="get">
                        <div class="widget">
                            <h2>Company Name</h2>
                            <input type="text" name="name" class="form-control" placeholder="Company Name ..."
                                value="{{ $form_name }}">
                        </div>

                        <div class="widget">
                            <h2>Company Industry</h2>
                            <select name="industry" class="form-control select2">
                                <option value="">Company Industry</option>
                                @foreach($company_industries as $item)
                                <option value="{{ $item->id }}" @if($form_industry==$item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Company Location</h2>
                            <select name="location" class="form-control select2">
                                <option value="">Company Location</option>
                                @foreach($company_locations as $item)
                                <option value="{{ $item->id }}" @if($form_location==$item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Company Size</h2>
                            <select name="size" class="form-control select2">
                                <option value="">Company Size</option>
                                @foreach($company_sizes as $item)
                                <option value="{{ $item->id }}" @if($form_size==$item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Founded On</h2>
                            <select name="founded" class="form-control select2">
                                <option value="">Founded On</option>
                                @for($i=1900;$i<=date('Y');$i++) <option value="{{ $i }}" @if($form_founded==$i)
                                    selected @endif>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>

                        <div class="filter-button">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </form>

                    <!-- Advertisement Section -->
                    @if($advertisement_data->company_listing_ad_status == 'Show')
                    <div class="advertisement">
                        @if($advertisement_data->company_listing_ad_url == null)
                        <img src="{{ asset('uploads/'.$advertisement_data->company_listing_ad) }}" alt="">
                        @else
                        <a href="{{ $advertisement_data->company_listing_ad_url }}" target="_blank">
                            <img src="{{ asset('uploads/'.$advertisement_data->company_listing_ad) }}" alt="">
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-9">
                <div class="job">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="search-result-header">
                                    <i class="fas fa-search"></i> Search Result for Company Listing
                                </div>
                            </div>

                            <!-- Check if there are no companies found -->
                            @if(!$companies->count())
                            <div class="text-danger">No Result Found</div>
                            @else
                            @foreach($companies as $item)
                            @php
                            // Checking if the company has an active order
                            $order_data = \App\Models\Order::where('company_id', $item->id)->where('currently_active',
                            1)->first();
                            if (!$order_data || date('Y-m-d') > $order_data->expire_date) {
                            continue; // Skip if no active order or if the order is expired
                            }
                            @endphp

                            <div class="col-md-12">
                                <div class="item d-flex justify-content-start">
                                    <div class="logo">
                                        <img src="{{ asset('uploads/'.$item->logo) }}" alt="">
                                    </div>
                                    <div class="text">
                                        <h3>
                                            <a href="{{ route('company', $item->id) }}">{{ $item->company_name }}</a>
                                            <!-- Company name linking to the company's detail page -->
                                        </h3>
                                        <div class="detail-1 d-flex justify-content-start">
                                            <div class="category">
                                                {{ $item->rCompanyIndustry ? $item->rCompanyIndustry->name : 'N/A' }}
                                                <!-- Displaying company industry or N/A if not available -->
                                            </div>
                                            <div class="location">
                                                {{ $item->rCompanyLocation ? $item->rCompanyLocation->name : 'N/A' }}
                                                <!-- Displaying company location or N/A if not available -->
                                            </div>
                                        </div>
                                        <div class="detail-2">
                                            @php
                                            $new_str = substr($item->description, 0, 220) . ' ...';
                                            @endphp
                                            {!! $new_str !!}
                                            <!-- Displaying a shortened description of the company -->
                                        </div>
                                        <div class="open-position">
                                            <span class="badge bg-primary">{{ $item->r_job_count }} Open
                                                Positions</span>
                                            <!-- Displaying the number of open positions at the company -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="col-md-12">
                                {{ $companies->appends($_GET)->links() }}
                                <!-- Pagination links for the company listings -->
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
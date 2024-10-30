@extends('front.layout.app')

@section('seo_title'){{ $pricing_page_item->title }}@endsection
@section('seo_meta_description'){{ $pricing_page_item->meta_description }}@endsection

@section('main_content')
<div class="page-top" style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_pricing) }}')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $pricing_page_item->heading }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content pricing">
    <div class="container">
        <div class="row pricing">
            @foreach($packages as $item)
            <div class="col-lg-4 mb_30">
                <div class="card mb-5 mb-lg-0">
                    <div class="card-body">
                        <h2 class="card-title">{{ $item->package_name }}</h2>
                        <h3 class="card-price">${{ $item->package_price }}</h3>
                        <h4 class="card-day">({{ $item->package_display_time }})</h4>
                        <hr />
                        <ul class="fa-ul">
                            @foreach (['total_allowed_jobs' => 'Job Post Allowed', 'total_allowed_featured_jobs' =>
                            'Featured Job', 'total_allowed_photos' => 'Company Photos', 'total_allowed_videos' =>
                            'Company Videos'] as $field => $label)
                            @php
                            $allowed = $item->$field;
                            $text = $allowed == -1 ? 'Unlimited' : ($allowed == 0 ? 'No' : $allowed);
                            $icon_code = $allowed == 0 ? 'fas fa-times' : 'fas fa-check';
                            @endphp
                            <li>
                                <span class="fa-li"><i class="{{ $icon_code }}"></i></span>
                                {{ $text }} {{ $label }}
                            </li>
                            @endforeach
                        </ul>
                        <div class="buy">
                            <a href="{{ route('company_make_payment') }}" class="btn btn-primary">Choose Plan</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
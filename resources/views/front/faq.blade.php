@extends('front.layout.app')

@section('seo_title'){{ $faq_page_item->title }}@endsection
@section('seo_meta_description'){{ $faq_page_item->meta_description }}@endsection

@section('main_content')

<!-- Top Banner Section for FAQ Page -->
<div class="page-top" style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_faq) }}')">
    <div class="bg"></div> <!-- Background overlay for visual effect -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Dynamic heading for the FAQ page -->
                <h2>{{ $faq_page_item->heading }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Content Section -->
<div class="page-content faq">
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <!-- Bootstrap Accordion Component for FAQ -->
                <div class="accordion" id="accordionExample">

                    <!-- Loop through FAQs dynamically -->
                    @php $i=0; @endphp
                    <!-- Initialize counter for unique IDs -->
                    @foreach($faqs as $item)
                    @php $i++; @endphp
                    <!-- Increment counter for each FAQ item -->

                    <!-- Accordion Item for Each FAQ -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $i }}">
                            <!-- Accordion button that toggles the answer visibility -->
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $i }}" <!-- Unique ID for each FAQ content -->
                                aria-expanded="false"
                                aria-controls="collapse{{ $i }}"
                                >
                                <!-- Display the FAQ question -->
                                {{ $item->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $i }}" <!-- Unique ID for the content being toggled -->
                            class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $i }}"
                            data-bs-parent="#accordionExample"
                            <!-- Ensures only one item is open at a time -->
                            >
                            <div class="accordion-body">
                                <!-- Display the FAQ answer with line breaks handled -->
                                {!! nl2br($item->answer) !!}
                            </div>
                        </div>
                    </div>

                    @endforeach

                </div>
                <!-- End of Accordion -->
            </div>
        </div>
    </div>
</div>

@endsection
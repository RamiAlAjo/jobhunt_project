@extends('front.layout.app')
<!-- Extends the main layout template for the front end, including shared elements like the header and footer -->

@section('main_content')
<!-- Main content section for the payment page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <!-- Top section with a background image specific to the company panel -->

    <div class="bg"></div>
    <!-- Overlay background effect for the banner -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Make Payment</h2>
                <!-- Heading for the "Make Payment" page -->
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
                    <!-- Includes the company sidebar, which contains navigation options for the company profile -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <h4>Current Plan</h4>
                <div class="row box-items mb-4">
                    <div class="col-md-4">
                        <div class="box1">
                            @if($current_plan == null)
                            <span class="text-danger">No plan is available</span>
                            <!-- Displays a message if no plan is currently active -->
                            @else
                            <h4>${{ $current_plan->rPackage->package_price }}</h4>
                            <p>{{ $current_plan->rPackage->package_name }}</p>
                            <!-- Displays the current plan's name and price if available -->
                            @endif
                        </div>
                    </div>
                </div>

                <h4>Choose Plan and Make Payment</h4>
                <!-- Section for selecting a new plan and making a payment -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <form action="{{ route('company_paypal') }}" method="post">
                            @csrf
                            <!-- PayPal payment form with CSRF protection -->

                            <tr>
                                <td class="w-200">
                                    <select name="package_id" class="form-control select2">
                                        @foreach($packages as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_name }}
                                            (${{ $item->package_price }})</option>
                                        @endforeach
                                        <!-- Dropdown list of available packages with package name and price -->
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        Pay with PayPal
                                    </button>
                                    <!-- Submit button for PayPal payment -->
                                </td>
                            </tr>
                        </form>

                        <tr>
                            <form action="{{ route('company_stripe') }}" method="post">
                                @csrf
                                <!-- Stripe payment form with CSRF protection -->

                                <td>
                                    <select name="package_id" class="form-control select2">
                                        @foreach($packages as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_name }}
                                            (${{ $item->package_price }})</option>
                                        @endforeach
                                        <!-- Dropdown list of available packages with package name and price -->
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        Pay with Stripe
                                    </button>
                                    <!-- Submit button for Stripe payment -->
                                </td>
                            </form>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of main content section -->
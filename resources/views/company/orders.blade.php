@extends('front.layout.app')
<!-- Extends the main front-end layout, which includes shared elements like the header and footer -->

@section('main_content')
<!-- Defines the main content section for the page -->

<div class="page-top"
    style="background-image: url('{{ asset('uploads/'.$global_banner_data->banner_company_panel) }}')">
    <!-- Page banner with background image specific to the company panel -->
    <div class="bg"></div>
    <!-- Background overlay for the banner -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Orders</h2>
                <!-- Page title indicating this is the "Orders" section -->
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <!-- Main content area with specific styling for the user panel -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    @include('company.sidebar')
                    <!-- Includes the sidebar for company navigation options -->
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <!-- Main content section displaying order details -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Order No</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Order Date</th>
                                <th>Expire Date</th>
                                <th>Payment Method</th>
                            </tr>
                            <!-- Header row defining column titles -->

                            @foreach($orders as $item)
                            <!-- Loops through each order item to create a row for each one -->

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Display the current iteration number -->

                                <td>{{ $item->order_no }}</td>
                                <!-- Displays the order number -->

                                <td>
                                    {{ $item->rPackage->package_name }}<br>
                                    <!-- Displays the package name associated with the , rPackage is a relationship property that links an order to its associated package -->

                                    @if($item->currently_active == 1)
                                    <!-- Checks if the package is currently active and shows an "Active" badge if true -->

                                    <span class="badge bg-success">Active</span>
                                    @endif
                                </td>

                                <td>${{ $item->paid_amount }}</td>
                                <!-- Displays the total amount paid for the order -->

                                <td>{{ $item->start_date }}</td>
                                <!-- Displays the order start date -->

                                <td>{{ $item->expire_date }}</td>
                                <!-- Displays the order expiration date -->

                                <td>{{ $item->payment_method }}</td>
                                <!-- Displays the payment method used for the order -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End of the orders table -->
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
<!-- End of the main content section -->
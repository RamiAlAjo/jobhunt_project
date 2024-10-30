<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character set and responsive design -->
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <!-- Favicon for the page -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/favicon.png') }}">
    <title>Admin Panel</title>

    <!-- Google Fonts for typography -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Include additional CSS styles -->
    @include('admin.layout.styles')

    <!-- Include additional JavaScript files -->
    @include('admin.layout.scripts')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">

            <!-- Include the navigation bar -->
            @include('admin.layout.nav')

            <!-- Include the sidebar -->
            @include('admin.layout.sidebar')

            <div class="main-content">
                <section class="section">
                    <!-- Section header with a dynamic heading and optional button -->
                    <div class="section-header justify-content-between">
                        <h1>@yield('heading')</h1>
                        @yield('button')
                    </div>
                    <!-- Main content area for dynamic content -->
                    @yield('main_content')
                </section>
            </div>
        </div>
    </div>

    <!-- Include additional JavaScript files to be loaded at the end -->
    @include('admin.layout.scripts_footer')

    <!-- Include Additional Scripts at the Bottom of the Page -->
    @include('front.layout.scripts_bottom')

    <!-- iziToast Notifications for Success and Error Messages -->
    @if($errors->any())
    @foreach($errors->all() as $error)
    <script>
    iziToast.error({
        title: 'Error',
        position: 'topRight',
        message: '{{ $error }}',
    });
    </script>
    @endforeach
    @endif

    @if(session('error'))
    <script>
    iziToast.error({
        title: 'Error',
        position: 'topRight',
        message: '{{ session('
        error ') }}',
    });
    </script>
    @endif

    @if(session('success'))
    <script>
    iziToast.success({
        title: 'Success',
        position: 'topRight',
        message: '{{ session('
        success ') }}',
    });
    </script>
    @endif


</body>

</html>
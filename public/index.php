<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check Maintenance Mode
|--------------------------------------------------------------------------
|
| If the application is in maintenance mode via the "down" command, this file
| will be loaded to show pre-rendered content instead of bootstrapping the
| full framework, which could throw an exception.
|
*/

$maintenanceFilePath = __DIR__ . '/../storage/framework/maintenance.php';

if (file_exists($maintenanceFilePath)) {
    require $maintenanceFilePath;
    exit; // Ensure that no further execution happens if in maintenance mode
}

/*
|--------------------------------------------------------------------------
| Register Autoloader
|--------------------------------------------------------------------------
|
| Composer provides an efficient class autoloader for this application. Here,
| we simply require it into the script, allowing us to autoload our classes.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap and Run Application
|--------------------------------------------------------------------------
|
| After retrieving the application instance, we handle the incoming request
| using the HTTP kernel, sending the response back to the client and
| terminating the kernel instance to complete the request lifecycle.
|
*/

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Log the error (or handle it as per your application needs)
    error_log($e->getMessage());
    // You can also redirect to a custom error page here
    http_response_code(500);
    echo 'An error occurred while processing your request.';
}
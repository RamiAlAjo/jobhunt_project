<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Purpose: This base controller provides foundational functionality for all 
 * other controllers in the application. By extending this class, other 
 * controllers inherit methods for authorization, job dispatching, and validation.
 */
class Controller extends BaseController
{
    // The AuthorizesRequests trait provides methods for authorizing actions based on user permissions.
    use AuthorizesRequests;
    
    // The DispatchesJobs trait allows dispatching jobs to the queue or handling them synchronously.
    use DispatchesJobs;
    
    // The ValidatesRequests trait provides methods for validating incoming HTTP requests.
    use ValidatesRequests;
}
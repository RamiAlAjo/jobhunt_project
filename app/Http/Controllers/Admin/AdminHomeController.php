<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Job;

// Define the AdminHomeController class to manage the admin dashboard home page
class AdminHomeController extends Controller
{
    // Display the dashboard with totals for companies, candidates, and jobs
    public function index()
    {
        // Count the total number of active companies
        $total_companies = Company::where('status', 1)->count();
        
        // Count the total number of active candidates
        $total_candidates = Candidate::where('status', 1)->count();
        
        // Count the total number of jobs, regardless of status
        $total_jobs = Job::count();

        // Return the 'admin.home' view, passing the total counts
        return view('admin.home', compact('total_companies', 'total_candidates', 'total_jobs'));
    }
}
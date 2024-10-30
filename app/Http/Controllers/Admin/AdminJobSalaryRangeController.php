<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobSalaryRange;
use App\Models\Job;

// Define the AdminJobSalaryRangeController class to handle job salary range-related actions in the admin panel
class AdminJobSalaryRangeController extends Controller
{
    // Display a list of all job salary ranges
    public function index()
    {
        // Retrieve all job salary ranges from the JobSalaryRange model
        $job_salary_ranges = JobSalaryRange::get();
        
        // Return the 'admin.job_salary_range' view, passing the list of job salary ranges
        return view('admin.job_salary_range', compact('job_salary_ranges'));
    }

    // Show the form for creating a new job salary range
    public function create()
    {
        // Return the 'admin.job_salary_range_create' view to display the creation form
        return view('admin.job_salary_range_create');
    }

    // Store a new job salary range in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new JobSalaryRange object, assign the name, and save it to the database
        $obj = new JobSalaryRange();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the job salary range list with a success message
        return redirect()->route('admin_job_salary_range')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing job salary range
    public function edit($id)
    {
        // Retrieve the specific job salary range by ID
        $job_salary_range_single = JobSalaryRange::where('id', $id)->first();
        
        // Return the 'admin.job_salary_range_edit' view, passing the job salary range data
        return view('admin.job_salary_range_edit', compact('job_salary_range_single'));
    }

    // Update an existing job salary range in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific job salary range by ID
        $obj = JobSalaryRange::where('id', $id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the job salary range list with a success message
        return redirect()->route('admin_job_salary_range')->with('success', 'Data is updated successfully.');
    }

    // Delete a job salary range from the database
    public function delete($id)
    {
        // Check if the job salary range is associated with any jobs
        $check = Job::where('job_salary_range_id', $id)->count();
        
        // If it is associated with jobs, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the job salary range and redirect with a success message
        JobSalaryRange::where('id', $id)->delete();
        return redirect()->route('admin_job_salary_range')->with('success', 'Data is deleted successfully.');
    }
}
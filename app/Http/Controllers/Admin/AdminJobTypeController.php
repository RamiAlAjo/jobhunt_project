<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobType;
use App\Models\Job;

// Define the AdminJobTypeController class to handle job type-related actions in the admin panel
class AdminJobTypeController extends Controller
{
    // Display a list of all job types
    public function index()
    {
        // Retrieve all job types from the JobType model
        $job_types = JobType::get();
        
        // Return the 'admin.job_type' view, passing the list of job types
        return view('admin.job_type', compact('job_types'));
    }

    // Show the form for creating a new job type
    public function create()
    {
        // Return the 'admin.job_type_create' view to display the creation form
        return view('admin.job_type_create');
    }

    // Store a new job type in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new JobType object, assign the name, and save it to the database
        $obj = new JobType();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the job type list with a success message
        return redirect()->route('admin_job_type')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing job type
    public function edit($id)
    {
        // Retrieve the specific job type by ID
        $job_type_single = JobType::where('id', $id)->first();
        
        // Return the 'admin.job_type_edit' view, passing the job type data
        return view('admin.job_type_edit', compact('job_type_single'));
    }

    // Update an existing job type in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific job type by ID
        $obj = JobType::where('id', $id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the job type list with a success message
        return redirect()->route('admin_job_type')->with('success', 'Data is updated successfully.');
    }

    // Delete a job type from the database
    public function delete($id)
    {
        // Check if the job type is associated with any jobs
        $check = Job::where('job_type_id', $id)->count();
        
        // If it is associated with jobs, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the job type and redirect with a success message
        JobType::where('id', $id)->delete();
        return redirect()->route('admin_job_type')->with('success', 'Data is deleted successfully.');
    }
}
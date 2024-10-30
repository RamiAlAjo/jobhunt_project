<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobLocation;
use App\Models\Job;

// Define the AdminJobLocationController class to handle job location-related actions in the admin panel
class AdminJobLocationController extends Controller
{
    // Display a list of all job locations
    public function index()
    {
        // Retrieve all job locations from the JobLocation model
        $job_locations = JobLocation::get();
        
        // Return the 'admin.job_location' view, passing the list of job locations
        return view('admin.job_location', compact('job_locations'));
    }

    // Show the form for creating a new job location
    public function create()
    {
        // Return the 'admin.job_location_create' view to display the creation form
        return view('admin.job_location_create');
    }

    // Store a new job location in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new JobLocation object, assign the name, and save it to the database
        $obj = new JobLocation();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the job location list with a success message
        return redirect()->route('admin_job_location')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing job location
    public function edit($id)
    {
        // Retrieve the specific job location by ID
        $job_location_single = JobLocation::where('id', $id)->first();
        
        // Return the 'admin.job_location_edit' view, passing the job location data
        return view('admin.job_location_edit', compact('job_location_single'));
    }

    // Update an existing job location in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific job location by ID
        $obj = JobLocation::where('id', $id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the job location list with a success message
        return redirect()->route('admin_job_location')->with('success', 'Data is updated successfully.');
    }

    // Delete a job location from the database
    public function delete($id)
    {
        // Check if the job location is associated with any jobs
        $check = Job::where('job_location_id', $id)->count();
        
        // If it is associated with jobs, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the job location and redirect with a success message
        JobLocation::where('id', $id)->delete();
        return redirect()->route('admin_job_location')->with('success', 'Data is deleted successfully.');
    }
}
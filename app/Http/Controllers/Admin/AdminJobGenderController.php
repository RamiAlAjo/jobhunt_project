<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobGender;
use App\Models\Job;

// Define the AdminJobGenderController class to handle job gender-related actions in the admin panel
class AdminJobGenderController extends Controller
{
    // Display a list of all job genders
    public function index()
    {
        // Retrieve all job genders from the JobGender model
        $job_genders = JobGender::get();
        
        // Return the 'admin.job_gender' view, passing the list of job genders
        return view('admin.job_gender', compact('job_genders'));
    }

    // Show the form for creating a new job gender
    public function create()
    {
        // Return the 'admin.job_gender_create' view to display the creation form
        return view('admin.job_gender_create');
    }

    // Store a new job gender in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new JobGender object, assign the name, and save it to the database
        $obj = new JobGender();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the job gender list with a success message
        return redirect()->route('admin_job_gender')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing job gender
    public function edit($id)
    {
        // Retrieve the specific job gender by ID
        $job_gender_single = JobGender::where('id', $id)->first();
        
        // Return the 'admin.job_gender_edit' view, passing the job gender data
        return view('admin.job_gender_edit', compact('job_gender_single'));
    }

    // Update an existing job gender in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific job gender by ID
        $obj = JobGender::where('id', $id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the job gender list with a success message
        return redirect()->route('admin_job_gender')->with('success', 'Data is updated successfully.');
    }

    // Delete a job gender from the database
    public function delete($id)
    {
        // Check if the job gender is associated with any jobs
        $check = Job::where('job_gender_id', $id)->count();
        
        // If it is associated with jobs, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the job gender and redirect with a success message
        JobGender::where('id', $id)->delete();
        return redirect()->route('admin_job_gender')->with('success', 'Data is deleted successfully.');
    }
}
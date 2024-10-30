<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobExperience;
use App\Models\Job;

// Define the AdminJobExperienceController class to handle job experience-related actions in the admin panel
class AdminJobExperienceController extends Controller
{
    // Display a list of all job experiences
    public function index()
    {
        // Retrieve all job experiences from the JobExperience model
        $job_experiences = JobExperience::get();
        
        // Return the 'admin.job_experience' view, passing the list of job experiences
        return view('admin.job_experience', compact('job_experiences'));
    }

    // Show the form for creating a new job experience
    public function create()
    {
        // Return the 'admin.job_experience_create' view to display the creation form
        return view('admin.job_experience_create');
    }

    // Store a new job experience in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new JobExperience object, assign the name, and save it to the database
        $obj = new JobExperience();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the job experience list with a success message
        return redirect()->route('admin_job_experience')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing job experience
    public function edit($id)
    {
        // Retrieve the specific job experience by ID
        $job_experience_single = JobExperience::where('id', $id)->first();
        
        // Return the 'admin.job_experience_edit' view, passing the job experience data
        return view('admin.job_experience_edit', compact('job_experience_single'));
    }

    // Update an existing job experience in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific job experience by ID
        $obj = JobExperience::where('id', $id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the job experience list with a success message
        return redirect()->route('admin_job_experience')->with('success', 'Data is updated successfully.');
    }

    // Delete a job experience from the database
    public function delete($id)
    {
        // Check if the job experience is associated with any jobs
        $check = Job::where('job_experience_id', $id)->count();
        
        // If it is associated with jobs, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the job experience and redirect with a success message
        JobExperience::where('id', $id)->delete();
        return redirect()->route('admin_job_experience')->with('success', 'Data is deleted successfully.');
    }
}
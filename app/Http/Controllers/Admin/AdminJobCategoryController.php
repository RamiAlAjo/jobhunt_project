<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\Job;

// Define the AdminJobCategoryController class to handle job category-related actions in the admin panel
class AdminJobCategoryController extends Controller
{
    // Display a list of all job categories
    public function index()
    {
        // Retrieve all job categories from the JobCategory model
        $job_categories = JobCategory::get();
        
        // Return the 'admin.job_category' view, passing the list of job categories
        return view('admin.job_category', compact('job_categories'));
    }

    // Show the form for creating a new job category
    public function create()
    {
        // Return the 'admin.job_category_create' view to display the creation form
        return view('admin.job_category_create');
    }

    // Store a new job category in the database
    public function store(Request $request)
    {
        // Validate that both 'name' and 'icon' fields are required
        $request->validate([
            'name' => 'required',
            'icon' => 'required'
        ]);

        // Create a new JobCategory object, assign the name and icon, and save it to the database
        $obj = new JobCategory();
        $obj->name = $request->name;
        $obj->icon = $request->icon;
        $obj->save();

        // Redirect to the job category list with a success message
        return redirect()->route('admin_job_category')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing job category
    public function edit($id)
    {
        // Retrieve the specific job category by ID
        $job_category_single = JobCategory::where('id', $id)->first();
        
        // Return the 'admin.job_category_edit' view, passing the job category data
        return view('admin.job_category_edit', compact('job_category_single'));
    }

    // Update an existing job category in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific job category by ID
        $obj = JobCategory::where('id', $id)->first();

        // Validate that both 'name' and 'icon' fields are required
        $request->validate([
            'name' => 'required',
            'icon' => 'required'
        ]);

        // Update the name and icon fields and save the changes to the database
        $obj->name = $request->name;
        $obj->icon = $request->icon;
        $obj->update();

        // Redirect to the job category list with a success message
        return redirect()->route('admin_job_category')->with('success', 'Data is updated successfully.');
    }

    // Delete a job category from the database
    public function delete($id)
    {
        // Check if the job category is associated with any jobs
        $check = Job::where('job_category_id', $id)->count();
        
        // If it is associated with jobs, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the job category and redirect with a success message
        JobCategory::where('id', $id)->delete();
        return redirect()->route('admin_job_category')->with('success', 'Data is deleted successfully.');
    }
}
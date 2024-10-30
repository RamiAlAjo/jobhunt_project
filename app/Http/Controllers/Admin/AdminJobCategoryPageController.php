<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageJobCategoryItem;

// Define the AdminJobCategoryPageController class to manage the job category page settings in the admin panel
class AdminJobCategoryPageController extends Controller
{
    // Display the job category page settings
    public function index()
    {
        // Retrieve the job category page data with an ID of 1 from the PageJobCategoryItem model
        $page_job_category_data = PageJobCategoryItem::where('id', 1)->first();
        
        // Return the 'admin.page_job_category' view, passing the retrieved job category page data
        return view('admin.page_job_category', compact('page_job_category_data'));
    }

    // Update the job category page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing job category page data with an ID of 1
        $job_category_page_data = PageJobCategoryItem::where('id', 1)->first();

        // Validate that the 'heading' field is required
        $request->validate([
            'heading' => 'required'
        ]);

        // Update the job category page data with values from the request
        $job_category_page_data->heading = $request->heading;
        $job_category_page_data->title = $request->title;
        $job_category_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $job_category_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
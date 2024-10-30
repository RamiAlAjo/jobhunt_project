<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageHomeItem;

// Define the AdminHomePageController class to manage the home page settings in the admin panel
class AdminHomePageController extends Controller
{
    // Display the home page settings
    public function index()
    {
        // Retrieve the home page data with an ID of 1 from the PageHomeItem model
        $page_home_data = PageHomeItem::where('id', 1)->first();
        
        // Return the 'admin.page_home' view, passing the retrieved home page data
        return view('admin.page_home', compact('page_home_data'));
    }

    // Update the home page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing home page data with an ID of 1
        $home_page_data = PageHomeItem::where('id', 1)->first();

        // Validate that all required fields are present in the form submission
        $request->validate([
            'heading' => 'required',
            'job_title' => 'required',
            'job_category' => 'required',
            'job_location' => 'required',
            'search' => 'required',
            'job_category_heading' => 'required',
            'job_category_status' => 'required',
            'why_choose_heading' => 'required',
            'why_choose_status' => 'required',
            'featured_jobs_heading' => 'required',
            'featured_jobs_status' => 'required',
            'testimonial_heading' => 'required',
            'testimonial_status' => 'required',
            'blog_heading' => 'required',
            'blog_status' => 'required'
        ]);

        // Check if a new background image for the home page banner is uploaded
        if ($request->hasFile('background')) {
            $request->validate([
                'background' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the old background image from the server
            unlink(public_path('uploads/' . $home_page_data->background));

            // Get the extension and save the new background image
            $ext = $request->file('background')->extension();
            $final_name = 'banner_home' . '.' . $ext;
            $request->file('background')->move(public_path('uploads/'), $final_name);

            $home_page_data->background = $final_name;
        }

        // Check if a new background image for the "Why Choose Us" section is uploaded
        if ($request->hasFile('why_choose_background')) {
            $request->validate([
                'why_choose_background' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the old "Why Choose Us" background image from the server
            unlink(public_path('uploads/' . $home_page_data->why_choose_background));

            // Get the extension and save the new image
            $ext1 = $request->file('why_choose_background')->extension();
            $final_name1 = 'why_choose_home_background' . '.' . $ext1;
            $request->file('why_choose_background')->move(public_path('uploads/'), $final_name1);

            $home_page_data->why_choose_background = $final_name1;
        }

        // Check if a new background image for the testimonial section is uploaded
        if ($request->hasFile('testimonial_background')) {
            $request->validate([
                'testimonial_background' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the old testimonial background image from the server
            unlink(public_path('uploads/' . $home_page_data->testimonial_background));

            // Get the extension and save the new image
            $ext1 = $request->file('testimonial_background')->extension();
            $final_name1 = 'testimonial_home_background' . '.' . $ext1;
            $request->file('testimonial_background')->move(public_path('uploads/'), $final_name1);

            $home_page_data->testimonial_background = $final_name1;
        }

        // Update various text fields and content sections with the new data from the request
        $home_page_data->heading = $request->heading;
        $home_page_data->text = $request->text;
        $home_page_data->job_title = $request->job_title;
        $home_page_data->job_category = $request->job_category;
        $home_page_data->job_location = $request->job_location;
        $home_page_data->search = $request->search;

        $home_page_data->job_category_heading = $request->job_category_heading;
        $home_page_data->job_category_subheading = $request->job_category_subheading;
        $home_page_data->job_category_status = $request->job_category_status;

        $home_page_data->why_choose_heading = $request->why_choose_heading;
        $home_page_data->why_choose_subheading = $request->why_choose_subheading;
        $home_page_data->why_choose_status = $request->why_choose_status;

        $home_page_data->featured_jobs_heading = $request->featured_jobs_heading;
        $home_page_data->featured_jobs_subheading = $request->featured_jobs_subheading;
        $home_page_data->featured_jobs_status = $request->featured_jobs_status;

        $home_page_data->testimonial_heading = $request->testimonial_heading;
        $home_page_data->testimonial_status = $request->testimonial_status;

        $home_page_data->blog_heading = $request->blog_heading;
        $home_page_data->blog_subheading = $request->blog_subheading;
        $home_page_data->blog_status = $request->blog_status;

        $home_page_data->title = $request->title;
        $home_page_data->meta_description = $request->meta_description;

        // Save the updated data to the database
        $home_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
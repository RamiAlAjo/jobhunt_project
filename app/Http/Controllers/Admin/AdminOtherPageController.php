<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageOtherItem;

// Define the AdminOtherPageController class to manage the "Other" page settings in the admin panel
class AdminOtherPageController extends Controller
{
    // Display the "Other" page settings
    public function index()
    {
        // Retrieve the "Other" page data with an ID of 1 from the PageOtherItem model
        $page_other_data = PageOtherItem::where('id', 1)->first();
        
        // Return the 'admin.page_other' view, passing the retrieved data
        return view('admin.page_other', compact('page_other_data'));
    }

    // Update the "Other" page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing "Other" page data with an ID of 1
        $other_page_data = PageOtherItem::where('id', 1)->first();

        // Validate that specific fields are required
        $request->validate([
            'login_page_heading' => 'required',
            'signup_page_heading' => 'required',
            'forget_password_page_heading' => 'required',
            'job_listing_page_heading' => 'required',
            'company_listing_page_heading' => 'required'
        ]);

        // Update the various page headings, titles, and meta descriptions with values from the request
        $other_page_data->login_page_heading = $request->login_page_heading;
        $other_page_data->login_page_title = $request->login_page_title;
        $other_page_data->login_page_meta_description = $request->login_page_meta_description;
        $other_page_data->signup_page_heading = $request->signup_page_heading;
        $other_page_data->signup_page_title = $request->signup_page_title;
        $other_page_data->signup_page_meta_description = $request->signup_page_meta_description;
        $other_page_data->forget_password_page_heading = $request->forget_password_page_heading;
        $other_page_data->forget_password_page_title = $request->forget_password_page_title;
        $other_page_data->forget_password_page_meta_description = $request->forget_password_page_meta_description;
        $other_page_data->job_listing_page_heading = $request->job_listing_page_heading;
        $other_page_data->job_listing_page_title = $request->job_listing_page_title;
        $other_page_data->job_listing_page_meta_description = $request->job_listing_page_meta_description;
        $other_page_data->company_listing_page_heading = $request->company_listing_page_heading;
        $other_page_data->company_listing_page_title = $request->company_listing_page_title;
        $other_page_data->company_listing_page_meta_description = $request->company_listing_page_meta_description;
        
        // Save the updated data to the database
        $other_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
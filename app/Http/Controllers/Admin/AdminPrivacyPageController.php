<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagePrivacyItem;

// Define the AdminPrivacyPageController class to manage the privacy page settings in the admin panel
class AdminPrivacyPageController extends Controller
{
    // Display the privacy page settings
    public function index()
    {
        // Retrieve the privacy page data with an ID of 1 from the PagePrivacyItem model
        $page_privacy_data = PagePrivacyItem::where('id', 1)->first();
        
        // Return the 'admin.page_privacy' view, passing the retrieved privacy page data
        return view('admin.page_privacy', compact('page_privacy_data'));
    }

    // Update the privacy page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing privacy page data with an ID of 1
        $privacy_page_data = PagePrivacyItem::where('id', 1)->first();

        // Validate that the 'heading' and 'content' fields are required
        $request->validate([
            'heading' => 'required',
            'content' => 'required'
        ]);

        // Update the privacy page data with values from the request
        $privacy_page_data->heading = $request->heading;
        $privacy_page_data->content = $request->content;
        $privacy_page_data->title = $request->title;
        $privacy_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $privacy_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
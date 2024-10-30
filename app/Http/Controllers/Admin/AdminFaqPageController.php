<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageFaqItem;

// Define the AdminFaqPageController class to manage FAQ page settings in the admin panel
class AdminFaqPageController extends Controller
{
    // Display the FAQ page settings
    public function index()
    {
        // Retrieve the FAQ page data with an ID of 1 from the PageFaqItem model
        $page_faq_data = PageFaqItem::where('id', 1)->first();
        
        // Return the 'admin.page_faq' view, passing the retrieved FAQ page data
        return view('admin.page_faq', compact('page_faq_data'));
    }

    // Update the FAQ page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing FAQ page data with an ID of 1
        $faq_page_data = PageFaqItem::where('id', 1)->first();

        // Validate that the 'heading' field is required
        $request->validate([
            'heading' => 'required'
        ]);

        // Update the FAQ page data with values from the request
        $faq_page_data->heading = $request->heading;
        $faq_page_data->title = $request->title;
        $faq_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $faq_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
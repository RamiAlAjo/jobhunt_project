<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageTermItem;

// Define the AdminTermPageController class to manage the terms and conditions page settings in the admin panel
class AdminTermPageController extends Controller
{
    // Display the terms and conditions page settings
    public function index()
    {
        // Retrieve the terms and conditions page data with an ID of 1 from the PageTermItem model
        $page_term_data = PageTermItem::where('id', 1)->first();
        
        // Return the 'admin.page_term' view, passing the retrieved terms page data
        return view('admin.page_term', compact('page_term_data'));
    }

    // Update the terms and conditions page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing terms and conditions page data with an ID of 1
        $term_page_data = PageTermItem::where('id', 1)->first();

        // Validate that both the 'heading' and 'content' fields are required
        $request->validate([
            'heading' => 'required',
            'content' => 'required'
        ]);

        // Update the terms page data with values from the request
        $term_page_data->heading = $request->heading;
        $term_page_data->content = $request->content;
        $term_page_data->title = $request->title;
        $term_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $term_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
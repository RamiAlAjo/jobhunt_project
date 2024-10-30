<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContactItem;

// Define the AdminContactPageController class to manage the contact page settings in the admin panel
class AdminContactPageController extends Controller
{
    // Display the contact page settings
    public function index()
    {
        // Retrieve the contact page data with an ID of 1 from the PageContactItem model
        $page_contact_data = PageContactItem::where('id', 1)->first();
        
        // Return the 'admin.page_contact' view, passing the retrieved contact page data
        return view('admin.page_contact', compact('page_contact_data'));
    }

    // Update the contact page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing contact page data with an ID of 1
        $contact_page_data = PageContactItem::where('id', 1)->first();

        // Validate that the 'heading' and 'map_code' fields are required
        $request->validate([
            'heading' => 'required',
            'map_code' => 'required'
        ]);

        // Update the contact page data with values from the request
        $contact_page_data->heading = $request->heading;
        $contact_page_data->map_code = $request->map_code;
        $contact_page_data->title = $request->title;
        $contact_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $contact_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
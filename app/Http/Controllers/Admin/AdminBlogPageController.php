<?php

// Define the namespace for this controller to organize it within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageBlogItem;

// Define the AdminBlogPageController class to manage blog page settings in the admin panel
class AdminBlogPageController extends Controller
{
    // Display the blog page settings
    public function index()
    {
        // Retrieve the blog page data with an ID of 1 from the PageBlogItem model
        $page_blog_data = PageBlogItem::where('id',1)->first();
        
        // Return the 'admin.page_blog' view, passing the retrieved blog page data to it
        return view('admin.page_blog', compact('page_blog_data'));
    }

    // Update the blog page settings based on the user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing blog page data with an ID of 1
        $blog_page_data = PageBlogItem::where('id',1)->first();

        // Validate that the 'heading' field is required
        $request->validate([
            'heading' => 'required'
        ]);

        // Update the blog page data with the values from the request
        $blog_page_data->heading = $request->heading;
        $blog_page_data->title = $request->title;
        $blog_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $blog_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
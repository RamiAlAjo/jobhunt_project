<?php

// Define the namespace for the controller to organize it within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

// Define the AdminBannerController class to handle banner-related actions in the admin panel
class AdminBannerController extends Controller
{
    // Method to display banner data
    public function index()
    {
        // Retrieve the banner data with an ID of 1 from the Banner model
        $banner_data = Banner::where('id',1)->first();
        
        // Return the 'admin.banner' view, passing the banner data to it
        return view('admin.banner', compact('banner_data'));
    }

    // Method to update banner images and data
    public function update(Request $request) 
    {
        // Retrieve the banner record with an ID of 1
        $obj = Banner::where('id',1)->first();

        // List of banner fields that may have images uploaded
        $bannerFields = [
            'banner_job_listing', 'banner_job_detail', 'banner_job_categories', 
            'banner_company_listing', 'banner_company_detail', 'banner_pricing', 
            'banner_blog', 'banner_post', 'banner_faq', 'banner_contact', 
            'banner_terms', 'banner_privacy', 'banner_signup', 'banner_login', 
            'banner_forget_password', 'banner_company_panel', 'banner_candidate_panel'
        ];

        // Loop through each banner field and handle file upload if present
        foreach ($bannerFields as $field) {
            if ($request->hasFile($field)) {
                // Validate that the uploaded file is an image in one of the specified formats
                $request->validate([
                    $field => 'image|mimes:jpg,jpeg,png,gif'
                ]);

                // Delete the existing banner image from the server
                unlink(public_path('uploads/'.$obj->$field));

                // Get the file extension of the uploaded image
                $ext = $request->file($field)->extension();
                
                // Define the final file name for the new image
                $final_name = $field.'.'.$ext;

                // Move the uploaded image to the public/uploads directory
                $request->file($field)->move(public_path('uploads/'),$final_name);

                // Update the banner field with the new file name
                $obj->$field = $final_name;
            }
        }

        // Save the updated banner data to the database
        $obj->update();

        // Redirect back with a success message after the update
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
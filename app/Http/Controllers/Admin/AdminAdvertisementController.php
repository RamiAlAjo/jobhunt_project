<?php

// Define the namespace for the controller to manage advertisements within the admin section
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;

// Define a controller class for handling advertisement-related operations in the admin panel
class AdminAdvertisementController extends Controller
{
    // Display the advertisement data in the admin view
    public function index()
    {
        // Retrieve the advertisement record with an id of 1 from the database
        $advertisement_data = Advertisement::where('id',1)->first();
        
        // Return the admin.advertisement view, passing the retrieved advertisement data to it
        return view('admin.advertisement', compact('advertisement_data'));
    }

    // Update the advertisement data based on the user's input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing advertisement record with an id of 1 from the database
        $obj = Advertisement::where('id',1)->first();

        // Check if a new file for job listing advertisement has been uploaded
        if($request->hasFile('job_listing_ad')) {
            // Validate that the uploaded file is an image in one of the specified formats
            $request->validate([
                'job_listing_ad' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the existing job listing advertisement file from the server
            unlink(public_path('uploads/'.$obj->job_listing_ad));

            // Get the file extension of the uploaded file
            $ext = $request->file('job_listing_ad')->extension();
            
            // Define the new file name for the uploaded advertisement image
            $final_name = 'job_listing_ad'.'.'.$ext;

            // Move the uploaded file to the public/uploads directory with the defined file name
            $request->file('job_listing_ad')->move(public_path('uploads/'),$final_name);

            // Update the job_listing_ad field in the advertisement record with the new file name
            $obj->job_listing_ad = $final_name;
        }

        // Check if a new file for company listing advertisement has been uploaded
        if($request->hasFile('company_listing_ad')) {
            // Validate that the uploaded file is an image in one of the specified formats
            $request->validate([
                'company_listing_ad' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the existing company listing advertisement file from the server
            unlink(public_path('uploads/'.$obj->company_listing_ad));

            // Get the file extension of the uploaded file
            $ext = $request->file('company_listing_ad')->extension();
            
            // Define the new file name for the uploaded advertisement image
            $final_name = 'company_listing_ad'.'.'.$ext;

            // Move the uploaded file to the public/uploads directory with the defined file name
            $request->file('company_listing_ad')->move(public_path('uploads/'),$final_name);

            // Update the company_listing_ad field in the advertisement record with the new file name
            $obj->company_listing_ad = $final_name;
        }
        
        // Update other advertisement details (URLs and statuses) based on the form inputs
        $obj->job_listing_ad_url = $request->job_listing_ad_url;
        $obj->job_listing_ad_status = $request->job_listing_ad_status;
        $obj->company_listing_ad_url = $request->company_listing_ad_url;
        $obj->company_listing_ad_status = $request->company_listing_ad_status;
        
        // Save the updated advertisement record to the database
        $obj->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
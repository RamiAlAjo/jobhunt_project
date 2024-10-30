<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

// Define the AdminSettingController class to handle site settings-related actions in the admin panel
class AdminSettingController extends Controller
{
    // Display the site settings page
    public function index()
    {
        // Retrieve the site settings with an ID of 1 from the Setting model
        $settings = Setting::where('id', 1)->first();
        
        // Return the 'admin.settings' view, passing the retrieved settings data
        return view('admin.settings', compact('settings'));
    }

    // Update the site settings based on user input from a form
    public function update(Request $request)
    {
        // Retrieve the existing site settings with an ID of 1
        $obj = Setting::where('id', 1)->first();

        // Validate that the 'copyright_text' field is required
        $request->validate([
            'copyright_text' => 'required'
        ]);

        // If a new logo is uploaded, validate and save it
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the existing logo from the server
            unlink(public_path('uploads/' . $obj->logo));

            // Save the new logo
            $ext = $request->file('logo')->extension();
            $final_name = 'logo' . '.' . $ext;
            $request->file('logo')->move(public_path('uploads/'), $final_name);
            $obj->logo = $final_name;
        }

        // If a new favicon is uploaded, validate and save it
        if ($request->hasFile('favicon')) {
            $request->validate([
                'favicon' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the existing favicon from the server
            unlink(public_path('uploads/' . $obj->favicon));

            // Save the new favicon
            $ext = $request->file('favicon')->extension();
            $final_name = 'favicon' . '.' . $ext;
            $request->file('favicon')->move(public_path('uploads/'), $final_name);
            $obj->favicon = $final_name;
        }

        // Update other settings fields with values from the request
        $obj->top_bar_phone = $request->top_bar_phone;
        $obj->top_bar_email = $request->top_bar_email;
        $obj->footer_phone = $request->footer_phone;
        $obj->footer_email = $request->footer_email;
        $obj->footer_address = $request->footer_address;
        $obj->facebook = $request->facebook;
        $obj->twitter = $request->twitter;
        $obj->linkedin = $request->linkedin;
        $obj->pinterest = $request->pinterest;
        $obj->instagram = $request->instagram;
        $obj->copyright_text = $request->copyright_text;
        
        // Save the updated settings to the database
        $obj->update();

        // Redirect back to the settings page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
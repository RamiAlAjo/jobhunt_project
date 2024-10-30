<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;
use Auth;

// Define the AdminProfileController class to handle admin profile-related actions in the admin panel
class AdminProfileController extends Controller
{
    // Display the admin profile page
    public function index()
    {
        // Return the 'admin.profile' view to display the profile page
        return view('admin.profile');
    }

    // Handle profile updates submitted by the admin
    public function profile_submit(Request $request)
    {
        // Retrieve the admin data for the currently authenticated admin
        $admin_data = Admin::where('email', Auth::guard('admin')->user()->email)->first();

        // Validate that the 'name' and 'email' fields are required
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        // If a new password is entered, validate and update it
        if ($request->password != '') {
            $request->validate([
                'password' => 'required',
                'retype_password' => 'required|same:password'
            ]);
            $admin_data->password = Hash::make($request->password);
        }

        // If a new profile photo is uploaded, validate and save it
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the existing photo from the server
            unlink(public_path('uploads/' . $admin_data->photo));

            // Save the new photo
            $ext = $request->file('photo')->extension();
            $final_name = 'admin' . '.' . $ext;
            $request->file('photo')->move(public_path('uploads/'), $final_name);
            $admin_data->photo = $final_name;
        }

        // Update the admin's name and email
        $admin_data->name = $request->name;
        $admin_data->email = $request->email;
        
        // Save the updated admin data to the database
        $admin_data->update();

        // Redirect back to the profile page with a success message
        return redirect()->back()->with('success', 'Profile information is saved successfully.');
    }
}
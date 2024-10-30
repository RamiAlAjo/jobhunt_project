<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Order;

// Define the AdminPackageController class to handle package-related actions in the admin panel
class AdminPackageController extends Controller
{
    // Display a list of all packages
    public function index()
    {
        // Retrieve all packages from the Package model
        $packages = Package::get();
        
        // Return the 'admin.package' view, passing the list of packages
        return view('admin.package', compact('packages'));
    }

    // Show the form for creating a new package
    public function create()
    {
        // Return the 'admin.package_create' view to display the creation form
        return view('admin.package_create');
    }

    // Store a new package in the database
    public function store(Request $request)
    {
        // Validate that specific fields are required for the package
        $request->validate([
            'package_name' => 'required',
            'package_price' => 'required',
            'package_days' => 'required',
            'package_display_time' => 'required',
            'total_allowed_jobs' => 'required',
            'total_allowed_featured_jobs' => 'required',
            'total_allowed_photos' => 'required',
            'total_allowed_videos' => 'required'
        ]);

        // Create a new Package object, assign the input values, and save it to the database
        $obj = new Package();
        $obj->package_name = $request->package_name;
        $obj->package_price = $request->package_price;
        $obj->package_days = $request->package_days;
        $obj->package_display_time = $request->package_display_time;
        $obj->total_allowed_jobs = $request->total_allowed_jobs;
        $obj->total_allowed_featured_jobs = $request->total_allowed_featured_jobs;
        $obj->total_allowed_photos = $request->total_allowed_photos;
        $obj->total_allowed_videos = $request->total_allowed_videos;
        $obj->save();

        // Redirect to the package list with a success message
        return redirect()->route('admin_package')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing package
    public function edit($id)
    {
        // Retrieve the specific package by ID
        $package_single = Package::where('id', $id)->first();
        
        // Return the 'admin.package_edit' view, passing the package data
        return view('admin.package_edit', compact('package_single'));
    }

    // Update an existing package in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific package by ID
        $obj = Package::where('id', $id)->first();

        // Validate that specific fields are required for the package
        $request->validate([
            'package_name' => 'required',
            'package_price' => 'required',
            'package_days' => 'required',
            'package_display_time' => 'required',
            'total_allowed_jobs' => 'required',
            'total_allowed_featured_jobs' => 'required',
            'total_allowed_photos' => 'required',
            'total_allowed_videos' => 'required'
        ]);

        // Update the package fields with the new values and save to the database
        $obj->package_name = $request->package_name;
        $obj->package_price = $request->package_price;
        $obj->package_days = $request->package_days;
        $obj->package_display_time = $request->package_display_time;
        $obj->total_allowed_jobs = $request->total_allowed_jobs;
        $obj->total_allowed_featured_jobs = $request->total_allowed_featured_jobs;
        $obj->total_allowed_photos = $request->total_allowed_photos;
        $obj->total_allowed_videos = $request->total_allowed_videos;
        $obj->update();

        // Redirect to the package list with a success message
        return redirect()->route('admin_package')->with('success', 'Data is updated successfully.');
    }

    // Delete a package from the database
    public function delete($id)
    {
        // Check if the package is associated with any orders
        $check = Order::where('package_id', $id)->count();
        
        // If it is associated with orders, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the package and redirect with a success message
        Package::where('id', $id)->delete();
        return redirect()->route('admin_package')->with('success', 'Data is deleted successfully.');
    }
}
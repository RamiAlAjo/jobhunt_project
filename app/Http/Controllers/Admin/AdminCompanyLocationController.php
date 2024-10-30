<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyLocation;
use App\Models\Company;

// Define the AdminCompanyLocationController class to handle company location-related actions in the admin panel
class AdminCompanyLocationController extends Controller
{
    // Display a list of all company locations
    public function index()
    {
        // Retrieve all company locations from the CompanyLocation model
        $company_locations = CompanyLocation::get();
        
        // Return the 'admin.company_location' view, passing the list of company locations
        return view('admin.company_location', compact('company_locations'));
    }

    // Show the form for creating a new company location
    public function create()
    {
        // Return the 'admin.company_location_create' view to display the creation form
        return view('admin.company_location_create');
    }

    // Store a new company location in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new CompanyLocation object, assign the name, and save it to the database
        $obj = new CompanyLocation();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the company location list with a success message
        return redirect()->route('admin_company_location')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing company location
    public function edit($id)
    {
        // Retrieve the specific company location by ID
        $company_location_single = CompanyLocation::where('id',$id)->first();
        
        // Return the 'admin.company_location_edit' view, passing the company location data
        return view('admin.company_location_edit', compact('company_location_single'));
    }

    // Update an existing company location in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific company location by ID
        $obj = CompanyLocation::where('id',$id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the company location list with a success message
        return redirect()->route('admin_company_location')->with('success', 'Data is updated successfully.');
    }

    // Delete a company location from the database
    public function delete($id)
    {
        // Check if the company location is associated with any companies
        $check = Company::where('company_location_id', $id)->count();
        
        // If it is associated with companies, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the company location and redirect with a success message
        CompanyLocation::where('id', $id)->delete();
        return redirect()->route('admin_company_location')->with('success', 'Data is deleted successfully.');
    }
}
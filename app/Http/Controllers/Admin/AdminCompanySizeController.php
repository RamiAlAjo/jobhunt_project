<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanySize;
use App\Models\Company;

// Define the AdminCompanySizeController class to handle company size-related actions in the admin panel
class AdminCompanySizeController extends Controller
{
    // Display a list of all company sizes
    public function index()
    {
        // Retrieve all company sizes from the CompanySize model
        $company_sizes = CompanySize::get();
        
        // Return the 'admin.company_size' view, passing the list of company sizes
        return view('admin.company_size', compact('company_sizes'));
    }

    // Show the form for creating a new company size
    public function create()
    {
        // Return the 'admin.company_size_create' view to display the creation form
        return view('admin.company_size_create');
    }

    // Store a new company size in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new CompanySize object, assign the name, and save it to the database
        $obj = new CompanySize();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the company size list with a success message
        return redirect()->route('admin_company_size')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing company size
    public function edit($id)
    {
        // Retrieve the specific company size by ID
        $company_size_single = CompanySize::where('id', $id)->first();
        
        // Return the 'admin.company_size_edit' view, passing the company size data
        return view('admin.company_size_edit', compact('company_size_single'));
    }

    // Update an existing company size in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific company size by ID
        $obj = CompanySize::where('id', $id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the company size list with a success message
        return redirect()->route('admin_company_size')->with('success', 'Data is updated successfully.');
    }

    // Delete a company size from the database
    public function delete($id)
    {
        // Check if the company size is associated with any companies
        $check = Company::where('company_size_id', $id)->count();
        
        // If it is associated with companies, prevent deletion and show an error message
        if ($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the company size and redirect with a success message
        CompanySize::where('id', $id)->delete();
        return redirect()->route('admin_company_size')->with('success', 'Data is deleted successfully.');
    }
}
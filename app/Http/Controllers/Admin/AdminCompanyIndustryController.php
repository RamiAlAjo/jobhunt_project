<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyIndustry;
use App\Models\Company;

// Define the AdminCompanyIndustryController class to handle company industry-related actions in the admin panel
class AdminCompanyIndustryController extends Controller
{
    // Display a list of all company industries
    public function index()
    {
        // Retrieve all company industries from the CompanyIndustry model
        $company_industries = CompanyIndustry::get();
        
        // Return the 'admin.company_industry' view, passing the list of company industries
        return view('admin.company_industry', compact('company_industries'));
    }

    // Show the form for creating a new company industry
    public function create()
    {
        // Return the 'admin.company_industry_create' view to display the creation form
        return view('admin.company_industry_create');
    }

    // Store a new company industry in the database
    public function store(Request $request)
    {
        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new CompanyIndustry object, assign the name, and save it to the database
        $obj = new CompanyIndustry();
        $obj->name = $request->name;
        $obj->save();

        // Redirect to the company industry list with a success message
        return redirect()->route('admin_company_industry')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing company industry
    public function edit($id)
    {
        // Retrieve the specific company industry by ID
        $company_industry_single = CompanyIndustry::where('id',$id)->first();
        
        // Return the 'admin.company_industry_edit' view, passing the company industry data
        return view('admin.company_industry_edit',compact('company_industry_single'));
    }

    // Update an existing company industry in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific company industry by ID
        $obj = CompanyIndustry::where('id',$id)->first();

        // Validate that the 'name' field is required
        $request->validate([
            'name' => 'required'
        ]);

        // Update the name field and save the changes to the database
        $obj->name = $request->name;
        $obj->update();

        // Redirect to the company industry list with a success message
        return redirect()->route('admin_company_industry')->with('success', 'Data is updated successfully.');
    }

    // Delete a company industry from the database
    public function delete($id)
    {
        // Check if the company industry is associated with any companies
        $check = Company::where('company_industry_id',$id)->count();
        
        // If it is associated with companies, prevent deletion and show an error message
        if($check > 0) {
            return redirect()->back()->with('error', 'You cannot delete this item because it is used in another place.');
        }

        // If not associated, delete the company industry and redirect with a success message
        CompanyIndustry::where('id',$id)->delete();
        return redirect()->route('admin_company_industry')->with('success', 'Data is deleted successfully.');
    }
}
<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagePricingItem;

// Define the AdminPricingPageController class to manage the pricing page settings in the admin panel
class AdminPricingPageController extends Controller
{
    // Display the pricing page settings
    public function index()
    {
        // Retrieve the pricing page data with an ID of 1 from the PagePricingItem model
        $page_pricing_data = PagePricingItem::where('id', 1)->first();
        
        // Return the 'admin.page_pricing' view, passing the retrieved pricing page data
        return view('admin.page_pricing', compact('page_pricing_data'));
    }

    // Update the pricing page settings based on user input from a form
    public function update(Request $request) 
    {
        // Retrieve the existing pricing page data with an ID of 1
        $pricing_page_data = PagePricingItem::where('id', 1)->first();

        // Validate that the 'heading' field is required
        $request->validate([
            'heading' => 'required'
        ]);

        // Update the pricing page data with values from the request
        $pricing_page_data->heading = $request->heading;
        $pricing_page_data->title = $request->title;
        $pricing_page_data->meta_description = $request->meta_description;
        
        // Save the updated data to the database
        $pricing_page_data->update();

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Data is updated successfully.');
    }
}
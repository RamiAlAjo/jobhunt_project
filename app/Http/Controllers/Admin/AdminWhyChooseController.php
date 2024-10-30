<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhyChooseItem;

// Define the AdminWhyChooseController class to handle "Why Choose Us" item-related actions in the admin panel
class AdminWhyChooseController extends Controller
{
    // Display a list of all "Why Choose Us" items
    public function index()
    {
        // Retrieve all items from the WhyChooseItem model
        $why_choose_items = WhyChooseItem::get();
        
        // Return the 'admin.why_choose_item' view, passing the list of items
        return view('admin.why_choose_item', compact('why_choose_items'));
    }

    // Show the form for creating a new "Why Choose Us" item
    public function create()
    {
        // Return the 'admin.why_choose_item_create' view to display the creation form
        return view('admin.why_choose_item_create');
    }

    // Store a new "Why Choose Us" item in the database
    public function store(Request $request)
    {
        // Validate that specific fields are required for the item
        $request->validate([
            'icon' => 'required',
            'heading' => 'required',
            'text' => 'required'
        ]);

        // Create a new WhyChooseItem object and assign form data to it
        $obj = new WhyChooseItem();
        $obj->icon = $request->icon;
        $obj->heading = $request->heading;
        $obj->text = $request->text;
        $obj->save();

        // Redirect to the item list with a success message
        return redirect()->route('admin_why_choose_item')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing "Why Choose Us" item
    public function edit($id)
    {
        // Retrieve the specific item by ID
        $why_choose_item_single = WhyChooseItem::where('id', $id)->first();
        
        // Return the 'admin.why_choose_item_edit' view, passing the item data
        return view('admin.why_choose_item_edit', compact('why_choose_item_single'));
    }

    // Update an existing "Why Choose Us" item in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific item by ID
        $obj = WhyChooseItem::where('id', $id)->first();

        // Validate required fields for the item
        $request->validate([
            'icon' => 'required',
            'heading' => 'required',
            'text' => 'required'
        ]);

        // Update the item fields with new values and save to the database
        $obj->icon = $request->icon;
        $obj->heading = $request->heading;
        $obj->text = $request->text;
        $obj->update();

        // Redirect to the item list with a success message
        return redirect()->route('admin_why_choose_item')->with('success', 'Data is updated successfully.');
    }

    // Delete a "Why Choose Us" item from the database
    public function delete($id)
    {
        // Delete the item by ID and redirect with a success message
        WhyChooseItem::where('id', $id)->delete();
        return redirect()->route('admin_why_choose_item')->with('success', 'Data is deleted successfully.');
    }
}
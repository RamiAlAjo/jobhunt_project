<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

// Define the AdminTestimonialController class to handle testimonial-related actions in the admin panel
class AdminTestimonialController extends Controller
{
    // Display a list of all testimonials
    public function index()
    {
        // Retrieve all testimonials from the Testimonial model
        $testimonials = Testimonial::get();
        
        // Return the 'admin.testimonial' view, passing the list of testimonials
        return view('admin.testimonial', compact('testimonials'));
    }

    // Show the form for creating a new testimonial
    public function create()
    {
        // Return the 'admin.testimonial_create' view to display the creation form
        return view('admin.testimonial_create');
    }

    // Store a new testimonial in the database
    public function store(Request $request)
    {
        // Validate that specific fields are required for the testimonial
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'comment' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        // Create a new Testimonial object and save the uploaded photo
        $obj = new Testimonial();
        $ext = $request->file('photo')->extension();
        $final_name = 'testimonial_' . time() . '.' . $ext;
        $request->file('photo')->move(public_path('uploads/'), $final_name);
        
        // Assign form data to the Testimonial object
        $obj->photo = $final_name;
        $obj->name = $request->name;
        $obj->designation = $request->designation;
        $obj->comment = $request->comment;
        $obj->save();

        // Redirect to the testimonial list with a success message
        return redirect()->route('admin_testimonial')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing testimonial
    public function edit($id)
    {
        // Retrieve the specific testimonial by ID
        $testimonial_single = Testimonial::where('id', $id)->first();
        
        // Return the 'admin.testimonial_edit' view, passing the testimonial data
        return view('admin.testimonial_edit', compact('testimonial_single'));
    }

    // Update an existing testimonial in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific testimonial by ID
        $obj = Testimonial::where('id', $id)->first();

        // Validate required fields for the testimonial
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'comment' => 'required',
        ]);

        // If a new photo is uploaded, validate and replace the existing photo
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            unlink(public_path('uploads/' . $obj->photo));
            $ext = $request->file('photo')->extension();
            $final_name = 'testimonial_' . time() . '.' . $ext;
            $request->file('photo')->move(public_path('uploads/'), $final_name);
            $obj->photo = $final_name;
        }

        // Update the testimonial fields with new values and save to the database
        $obj->name = $request->name;
        $obj->designation = $request->designation;
        $obj->comment = $request->comment;
        $obj->update();

        // Redirect to the testimonial list with a success message
        return redirect()->route('admin_testimonial')->with('success', 'Data is updated successfully.');
    }

    // Delete a testimonial from the database
    public function delete($id)
    {
        // Retrieve the specific testimonial by ID and delete its associated photo
        $testimonial_single = Testimonial::where('id', $id)->first();
        unlink(public_path('uploads/' . $testimonial_single->photo));
        
        // Delete the testimonial and redirect with a success message
        Testimonial::where('id', $id)->delete();
        return redirect()->route('admin_testimonial')->with('success', 'Data is deleted successfully.');
    }
}
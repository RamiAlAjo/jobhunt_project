<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

// Define the AdminFaqController class to manage FAQ-related actions in the admin panel
class AdminFaqController extends Controller
{
    // Display a list of all FAQs
    public function index()
    {
        // Retrieve all FAQs from the Faq model
        $faqs = Faq::get();
        
        // Return the 'admin.faq' view, passing the list of FAQs
        return view('admin.faq', compact('faqs'));
    }

    // Show the form for creating a new FAQ
    public function create()
    {
        // Return the 'admin.faq_create' view to display the creation form
        return view('admin.faq_create');
    }

    // Store a new FAQ in the database
    public function store(Request $request)
    {
        // Validate that both 'question' and 'answer' fields are required
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        // Create a new Faq object, assign the question and answer, and save it to the database
        $obj = new Faq();
        $obj->question = $request->question;
        $obj->answer = $request->answer;
        $obj->save();

        // Redirect to the FAQ list with a success message
        return redirect()->route('admin_faq')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing FAQ
    public function edit($id)
    {
        // Retrieve the specific FAQ by ID
        $faq_single = Faq::where('id', $id)->first();
        
        // Return the 'admin.faq_edit' view, passing the FAQ data
        return view('admin.faq_edit', compact('faq_single'));
    }

    // Update an existing FAQ in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific FAQ by ID
        $obj = Faq::where('id', $id)->first();

        // Validate that both 'question' and 'answer' fields are required
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        // Update the question and answer fields and save the changes to the database
        $obj->question = $request->question;
        $obj->answer = $request->answer;
        $obj->update();

        // Redirect to the FAQ list with a success message
        return redirect()->route('admin_faq')->with('success', 'Data is updated successfully.');
    }

    // Delete an FAQ from the database
    public function delete($id)
    {
        // Delete the specific FAQ by ID
        Faq::where('id', $id)->delete();
        
        // Redirect to the FAQ list with a success message
        return redirect()->route('admin_faq')->with('success', 'Data is deleted successfully.');
    }
}
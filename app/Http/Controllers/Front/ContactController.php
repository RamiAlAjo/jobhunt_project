<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Websitemail;
use App\Models\Admin;
use App\Models\PageContactItem;

class ContactController extends Controller
{
    // Display the contact page with relevant content
    public function index() 
    {
        // Retrieve contact page details from the database
        // This data might include contact information or page-specific content
        $contact_page_item = PageContactItem::where('id', 1)->first();

        // Pass the retrieved data to the contact view for rendering
        return view('front.contact', compact('contact_page_item'));
    }

    // Handle the form submission from the contact page
    public function submit(Request $request)
    {
        // Fetch admin details from the database
        // Assumes there is an Admin model with contact details, like an email address, to which the message will be sent
        $admin_data = Admin::where('id', 1)->first();

        // Validate the form inputs to ensure that all necessary fields are provided and valid
        $request->validate([
            'person_name' => 'required',        // Name is required
            'person_email' => 'required|email', // Email is required and must be in a valid email format
            'person_message' => 'required'      // Message content is required
        ]);

        // Construct the email content using the visitor's information
        // This content includes the visitor's name, email, and message, formatted as HTML
        $subject = 'Contact Form Message'; // Subject line of the email
        $message = 'Visitor Information: <br>';
        $message .= 'Name: ' . $request->person_name . '<br>';
        $message .= 'Email: ' . $request->person_email . '<br>';
        $message .= 'Message: ' . $request->person_message;

        // Send the email to the admin's email address using Laravel's Mail facade
        // The Websitemail Mailable class handles the email content and formatting
        \Mail::to($admin_data->email)->send(new Websitemail($subject, $message));

        // Redirect back to the contact page with a success message for the user
        // The message confirms that the email was sent successfully and that the admin will contact them soon
        return redirect()->back()->with('success', 'Email is sent successfully! We will contact you soon.');
    }
}
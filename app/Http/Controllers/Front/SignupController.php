<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageOtherItem;
use App\Models\Company;
use App\Models\Candidate;
use App\Mail\Websitemail;
use Hash;
use Auth;

/**
 * Purpose: This controller handles the signup process for both companies 
 * and candidates, including validation, account creation, email verification, 
 * and enabling secure login access after email confirmation.
 */
class SignupController extends Controller
{
    /**
     * Displays the signup page.
     * Redirects authenticated users to their respective dashboards.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Redirect if a candidate is already logged in
        if(Auth::guard('candidate')->check()) {
            return redirect()->route('candidate_dashboard');
        }

        // Redirect if a company is already logged in
        if(Auth::guard('company')->check()) {
            return redirect()->route('company_dashboard');
        }
        
        // Retrieve additional page settings for signup page content
        $other_page_item = PageOtherItem::where('id', 1)->first();
        
        // Render the signup view with the page settings
        return view('front.signup', compact('other_page_item'));
    }

    /**
     * Handles the signup submission for companies.
     * Validates input data, creates a company account, and sends a verification email.
     *
     * @param  Request $request The incoming HTTP request containing form data.
     * @return \Illuminate\Http\RedirectResponse Redirects user after signup, usually to the login page with a success message.
     */
    public function company_signup_submit(Request $request)
    {
        // Validate input data with custom rules for password strength and unique checks for username/email
        $request->validate([
            'company_name' => 'required',
            'person_name' => 'required',
            'username' => 'required|unique:companies',  // Username must be unique in the 'companies' table
            'email' => 'required|email|unique:companies', // Email must be unique and valid
            'password' => [
                'required',
                // Password must meet complexity rules: at least 8 characters, include uppercase, lowercase, number, and special character
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/'
            ],
            'retype_password' => 'required|same:password' // Retyped password must match the password
        ], [
            'password.regex' => 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.'
        ]);

        // Generate a unique token for email verification using the current timestamp
        $token = hash('sha256', time());

        // Create a new company instance and assign form values
        $obj = new Company();
        $obj->company_name = $request->company_name;
        $obj->person_name = $request->person_name;
        $obj->username = $request->username;
        $obj->email = $request->email;
        $obj->password = Hash::make($request->password); // Hash the password securely
        $obj->token = $token; // Store the generated token
        $obj->status = 0; // Set status to inactive (0) until email verification
        $obj->save(); // Save the company record to the database

        // Create the verification email link with the token and email parameters
        $verify_link = url('company_signup_verify/' . $token . '/' . $request->email);
        $subject = 'Company Signup Verification'; // Email subject
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="' . $verify_link . '">Click here</a>'; // Email body with clickable link

        // Send verification email to the company email
        \Mail::to($request->email)->send(new Websitemail($subject, $message));

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'An email is sent to your email address. Please click on the confirmation link to validate your signup.');
    }

    /**
     * Verifies the company account using the token and activates the account.
     * If token and email match, the account is verified and activated.
     *
     * @param  string $token The unique token sent to the user's email.
     * @param  string $email The email address of the company account being verified.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page after verification.
     */
    public function company_signup_verify($token, $email)
    {
        // Find the company by matching both token and email
        $company_data = Company::where('token', $token)->where('email', $email)->first();
        
        // If no matching record is found, redirect to login (verification failed)
        if (!$company_data) {
            return redirect()->route('login');
        }

        // If found, activate the company account by clearing the token and setting status to 1 (active)
        $company_data->token = '';
        $company_data->status = 1;
        $company_data->update(); // Update the company record

        // Redirect to login page with a success message
        return redirect()->route('login')->with('success', 'Your email is verified successfully. You can now login to the system as a company.');
    }

    /**
     * Handles the signup submission for candidates.
     * Validates input data, creates a candidate account, and sends a verification email.
     *
     * @param  Request $request The incoming HTTP request containing form data.
     * @return \Illuminate\Http\RedirectResponse Redirects user after signup, usually to the login page with a success message.
     */
    public function candidate_signup_submit(Request $request)
    {
        // Validate input data with custom rules for password strength and unique checks for username/email
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:candidates', // Username must be unique in the 'candidates' table
            'email' => 'required|email|unique:candidates', // Email must be unique and valid
            'password' => [
                'required',
                // Password must meet complexity rules: at least 8 characters, include uppercase, lowercase, number, and special character
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/'
            ],
            'retype_password' => 'required|same:password' // Retyped password must match the password
        ], [
            'password.regex' => 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.'
        ]);

        // Generate a unique token for email verification using the current timestamp
        $token = hash('sha256', time());

        // Create a new candidate instance and assign form values
        $obj = new Candidate();
        $obj->name = $request->name;
        $obj->username = $request->username;
        $obj->email = $request->email;
        $obj->password = Hash::make($request->password); // Hash the password securely
        $obj->token = $token; // Store the generated token
        $obj->status = 0; // Set status to inactive (0) until email verification
        $obj->save(); // Save the candidate record to the database

        // Create the verification email link with the token and email parameters
        $verify_link = url('candidate_signup_verify/' . $token . '/' . $request->email);
        $subject = 'Candidate Signup Verification'; // Email subject
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="' . $verify_link . '">Click here</a>'; // Email body with clickable link

        // Send verification email to the candidate email
        \Mail::to($request->email)->send(new Websitemail($subject, $message));

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'An email is sent to your email address. Please click on the confirmation link to validate your signup.');
    }

    /**
     * Verifies the candidate account using the token and activates the account.
     * If token and email match, the account is verified and activated.
     *
     * @param  string $token The unique token sent to the user's email.
     * @param  string $email The email address of the candidate account being verified.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page after verification.
     */
    public function candidate_signup_verify($token, $email)
    {
        // Find the candidate by matching both token and email
        $candidate_data = Candidate::where('token', $token)->where('email', $email)->first();
        
        // If no matching record is found, redirect to login (verification failed)
        if (!$candidate_data) {
            return redirect()->route('login');
        }

        // If found, activate the candidate account by clearing the token and setting status to 1 (active)
        $candidate_data->token = '';
        $candidate_data->status = 1;
        $candidate_data->update(); // Update the candidate record

        // Redirect to login page with a success message
        return redirect()->route('login')->with('success', 'Your email is verified successfully. You can now login to the system as a candidate.');
    }
}
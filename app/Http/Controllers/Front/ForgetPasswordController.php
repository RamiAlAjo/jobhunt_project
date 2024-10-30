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
 * Purpose: This controller manages the "Forgot Password" and "Reset Password" processes
 * for both companies and candidates. It includes methods for requesting a password reset 
 * link, validating the reset link, and updating the password for the respective user.
 */
class ForgetPasswordController extends Controller
{
    /**
     * Displays the "Forgot Password" page for companies.
     * Redirects to respective dashboards if already authenticated.
     */
    public function company_forget_password() 
    {
        // Check if a candidate is logged in, redirect to their dashboard if true
        if(Auth::guard('candidate')->check()) {
            return redirect()->route('candidate_dashboard');
        }

        // Check if a company is logged in, redirect to their dashboard if true
        if(Auth::guard('company')->check()) {
            return redirect()->route('company_dashboard');
        }

        // Retrieve page-specific settings and display the "Forgot Password" page for companies
        $other_page_item = PageOtherItem::where('id',1)->first();
        return view('front.forget_password_company', compact('other_page_item'));
    }

    /**
     * Handles the submission of the "Forgot Password" form for companies.
     * Validates the email and sends a password reset link if the email is registered.
     */
    public function company_forget_password_submit(Request $request)
    {
        // Validate the email format
        $request->validate([
            'email' => 'required|email'
        ]);

        // Look up the company by email, redirect back with an error if not found
        $company_data = Company::where('email',$request->email)->first();
        if(!$company_data) {
            return redirect()->back()->with('error','Email address not found!');
        }

        // Generate a unique token for password reset
        $token = hash('sha256',time());
        $company_data->token = $token;
        $company_data->update();

        // Create a reset link and send it to the company's email
        $reset_link = url('reset-password/company/'.$token.'/'.$request->email);
        $subject = 'Reset Password';
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="'.$reset_link.'">Click here</a>';
        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        // Redirect to login page with success message
        return redirect()->route('login')->with('success','Please check your email and follow the steps there.');
    }

    /**
     * Validates the password reset link for companies and displays the password reset form.
     * Redirects to the login page if the token is invalid.
     */
    public function company_reset_password($token, $email)
    {
        // Verify if the token and email match a company record
        $company_data = Company::where('token',$token)->where('email',$email)->first();
        if(!$company_data) {
            return redirect()->route('login');
        }

        // Display the "Reset Password" form if valid
        return view('front.reset_password_company', compact('token','email'));
    }

    /**
     * Handles the submission of the company password reset form.
     * Validates the new password and updates it for the company.
     */
    public function company_reset_password_submit(Request $request)
    {
        // Validate password and retyped password match
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        // Retrieve the company using the token and email, update the password and clear the token
        $company_data = Company::where('token',$request->token)->where('email',$request->email)->first();
        $company_data->password = Hash::make($request->password);
        $company_data->token = '';  // Clear the token after reset
        $company_data->update();

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Password is reset successfully. You can now login to the system.');
    }

    /**
     * Displays the "Forgot Password" page for candidates.
     * Redirects to respective dashboards if already authenticated.
     */
    public function candidate_forget_password() 
    {
        // Check if a candidate or company is logged in, redirect to respective dashboard
        if(Auth::guard('candidate')->check()) {
            return redirect()->route('candidate_dashboard');
        }

        if(Auth::guard('company')->check()) {
            return redirect()->route('company_dashboard');
        }
        
        // Retrieve page-specific settings and display the "Forgot Password" page for candidates
        $other_page_item = PageOtherItem::where('id',1)->first();
        return view('front.forget_password_candidate', compact('other_page_item'));
    }

    /**
     * Handles the submission of the "Forgot Password" form for candidates.
     * Validates the email and sends a password reset link if the email is registered.
     */
    public function candidate_forget_password_submit(Request $request)
    {
        // Validate the email format
        $request->validate([
            'email' => 'required|email'
        ]);

        // Look up the candidate by email, redirect back with an error if not found
        $candidate_data = Candidate::where('email',$request->email)->first();
        if(!$candidate_data) {
            return redirect()->back()->with('error','Email address not found!');
        }

        // Generate a unique token for password reset
        $token = hash('sha256',time());
        $candidate_data->token = $token;
        $candidate_data->update();

        // Create a reset link and send it to the candidate's email
        $reset_link = url('reset-password/candidate/'.$token.'/'.$request->email);
        $subject = 'Reset Password';
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="'.$reset_link.'">Click here</a>';
        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        // Redirect to login page with success message
        return redirect()->route('login')->with('success','Please check your email and follow the steps there.');
    }

    /**
     * Validates the password reset link for candidates and displays the password reset form.
     * Redirects to the login page if the token is invalid.
     */
    public function candidate_reset_password($token, $email)
    {
        // Verify if the token and email match a candidate record
        $candidate_data = Candidate::where('token',$token)->where('email',$email)->first();
        if(!$candidate_data) {
            return redirect()->route('login');
        }

        // Display the "Reset Password" form if valid
        return view('front.reset_password_candidate', compact('token','email'));
    }

    /**
     * Handles the submission of the candidate password reset form.
     * Validates the new password and updates it for the candidate.
     */
    public function candidate_reset_password_submit(Request $request)
    {
        // Validate password and retyped password match
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        // Retrieve the candidate using the token and email, update the password and clear the token
        $candidate_data = Candidate::where('token',$request->token)->where('email',$request->email)->first();
        $candidate_data->password = Hash::make($request->password);
        $candidate_data->token = '';  // Clear the token after reset
        $candidate_data->update();

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Password is reset successfully. You can now login to the system.');
    }
}
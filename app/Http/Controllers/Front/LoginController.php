<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageOtherItem;
use Auth;
use Hash;

/**
 * Purpose: This controller manages the login and logout functionalities for 
 * both candidates and companies. It provides methods for displaying the login page, 
 * handling login submissions, and logging out users, ensuring access control for 
 * the application.
 */
class LoginController extends Controller
{
    /**
     * Displays the login page.
     * Redirects authenticated users to their respective dashboards.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Redirect candidates who are already logged in to their dashboard
        if(Auth::guard('candidate')->check()) {
            return redirect()->route('candidate_dashboard');
        }

        // Redirect companies who are already logged in to their dashboard
        if(Auth::guard('company')->check()) {
            return redirect()->route('company_dashboard');
        }

        // Retrieve additional page settings for the login page and display the view
        $other_page_item = PageOtherItem::where('id',1)->first();
        return view('front.login', compact('other_page_item'));
    }

    /**
     * Handles the login submission for companies.
     * Validates the request data and attempts to log in the company.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function company_login_submit(Request $request)
    {
        // Validate login credentials input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Define the credentials array with a status check for active accounts only
        $credential = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 1 // Only allow active company accounts to log in
        ];

        // Attempt to authenticate the company; redirect to dashboard on success
        if(Auth::guard('company')->attempt($credential)) {
            return redirect()->route('company_dashboard');
        } else {
            // Redirect back to login page with error message if authentication fails
            return redirect()->route('login')->with('error', 'Information is not correct!');
        }
    }

    /**
     * Logs out the authenticated company user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function company_logout()
    {
        // Log out the company user and redirect to the login page
        Auth::guard('company')->logout();
        return redirect()->route('login');
    }

    /**
     * Handles the login submission for candidates.
     * Validates the request data and attempts to log in the candidate.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function candidate_login_submit(Request $request)
    {
        // Validate login credentials input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Define the credentials array with a status check for active accounts only
        $credential = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 1 // Only allow active candidate accounts to log in
        ];

        // Attempt to authenticate the candidate; redirect to dashboard on success
        if(Auth::guard('candidate')->attempt($credential)) {
            return redirect()->route('candidate_dashboard');
        } else {
            // Redirect back to login page with error message if authentication fails
            return redirect()->route('login')->with('error', 'Information is not correct!');
        }
    }

    /**
     * Logs out the authenticated candidate user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function candidate_logout()
    {
        // Log out the candidate user and redirect to the login page
        Auth::guard('candidate')->logout();
        return redirect()->route('login');
    }
}
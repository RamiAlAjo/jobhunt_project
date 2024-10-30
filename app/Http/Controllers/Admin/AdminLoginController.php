<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Mail\Websitemail;
use Hash;
use Auth;

// Define the AdminLoginController class to handle admin authentication-related actions in the admin panel
class AdminLoginController extends Controller
{
    // Display the admin login page
    public function index()
    {
        return view('admin.login');
    }

    // Display the forget password page
    public function forget_password()
    {
        return view('admin.forget_password');
    }

    // Handle forget password form submission and send reset link
    public function forget_password_submit(Request $request)
    {
        // Validate that the email field is required and must be in email format
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if the admin with the specified email exists
        $admin_data = Admin::where('email', $request->email)->first();
        if (!$admin_data) {
            return redirect()->back()->with('error', 'Email address not found!');
        }

        // Generate a unique token for password reset
        $token = hash('sha256', time());
        $admin_data->token = $token;
        $admin_data->update();

        // Create a reset link and email content
        $reset_link = url('admin/reset-password/'.$token.'/'.$request->email);
        $subject = 'Reset Password';
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="'.$reset_link.'">Click here</a>';

        // Send the reset link to the admin's email
        \Mail::to($request->email)->send(new Websitemail($subject, $message));

        // Redirect to login with success message
        return redirect()->route('admin_login')->with('success', 'Please check your email and follow the steps there');
    }

    // Handle admin login form submission
    public function login_submit(Request $request)
    {
        // Validate that both email and password fields are required
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Prepare the credentials array for authentication
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($credential)) {
            return redirect()->route('admin_home');
        } else {
            return redirect()->route('admin_login')->with('error', 'Information is not correct!');
        }
    }

    // Handle admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login');
    }

    // Display the reset password page using token and email verification
    public function reset_password($token, $email)
    {
        // Check if the admin with the specified token and email exists
        $admin_data = Admin::where('token', $token)->where('email', $email)->first();
        if (!$admin_data) {
            return redirect()->route('admin_login');
        }

        // Return the reset password view with token and email
        return view('admin.reset_password', compact('token', 'email'));
    }

    // Handle reset password form submission and update password
    public function reset_password_submit(Request $request)
    {
        // Validate the password fields to ensure they match
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        // Retrieve admin data using token and email
        $admin_data = Admin::where('token', $request->token)->where('email', $request->email)->first();

        // Update the password and reset the token
        $admin_data->password = Hash::make($request->password);
        $admin_data->token = '';
        $admin_data->update();

        // Redirect to login with success message
        return redirect()->route('admin_login')->with('success', 'Password is reset successfully');
    }
}
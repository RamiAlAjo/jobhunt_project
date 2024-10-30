<?php



// Table of Contents

// ### Company Controller
// 1. **Namespace and Imports**
//    - Declares the namespace and imports necessary classes and models.

// 2. **Class Declaration**
//    - `CompanyController` class extending the base Controller.

// 3. **Dashboard Method**
//    - **`dashboard()`**
//      - Displays the company dashboard with job statistics.

// 4. **Order Management Methods**
//    - **`orders()`**
//      - Displays all orders made by the company.

// 5. **Profile Edit Methods**
//    - **`edit_profile()`**
//      - Displays the company profile edit form.
//    - **`edit_profile_update(Request $request)`**
//      - Validates and updates the company profile data, including logo.

// 6. **Password Edit Methods**
//    - **`edit_password()`**
//      - Displays the password edit form.
//    - **`edit_password_update(Request $request)`**
//      - Validates and updates the company password.

// 7. **Photos Management Methods**
//    - **`photos()`**
//      - Displays the company's uploaded photos.
//    - **`photos_submit(Request $request)`**
//      - Validates and uploads a new photo.
//    - **`photos_delete($id)`**
//      - Deletes a specified photo.

// 8. **Videos Management Methods**
//    - **`videos()`**
//      - Displays the company's uploaded videos.
//    - **`videos_submit(Request $request)`**
//      - Validates and stores a new video.
//    - **`videos_delete($id)`**
//      - Deletes a specified video.

// 9. **Payment Methods**
//    - **`make_payment()`**
//      - Displays payment options for the company's package.
//    - **`paypal(Request $request)`**
//      - Initiates PayPal payment processing.
//    - **`paypal_success(Request $request)`**
//      - Handles successful PayPal payments and updates order details.
//    - **`paypal_cancel()`**
//      - Handles canceled PayPal payments.
//    - **`stripe(Request $request)`**
//      - Initiates Stripe payment processing.
//    - **`stripe_success()`**
//      - Handles successful Stripe payments and updates order details.
//    - **`stripe_cancel()`**
//      - Handles canceled Stripe payments.

// 10. **Job Management Methods**
//     - **`jobs_create()`**
//       - Displays the create job form with validation for packages.
//     - **`jobs_create_submit(Request $request)`**
//       - Validates and stores a new job.
//     - **`jobs()`**
//       - Displays all jobs posted by the company.
//     - **`jobs_edit($id)`**
//       - Displays the edit job form.
//     - **`jobs_update(Request $request, $id)`**
//       - Validates and updates job data.
//     - **`jobs_delete($id)`**
//       - Deletes a job along with associated applications and bookmarks.

// 11. **Candidate Applications Management**
//     - **`candidate_applications()`**
//       - Displays jobs with associated applications.
//     - **`applicants($id)`**
//       - Displays applicants for a specific job.
//     - **`applicant_resume($id)`**
//       - Displays the resume and details of a specific applicant.
//     - **`application_status_change(Request $request)`**
//       - Updates the application status and notifies the candidate via email.

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Package;
use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\CompanyIndustry;
use App\Models\CompanySize;
use App\Models\CompanyPhoto;
use App\Models\CompanyVideo;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\JobType;
use App\Models\JobExperience;
use App\Models\JobGender;
use App\Models\JobSalaryRange;
use App\Models\Candidate;
use App\Models\CandidateApplication;
use App\Models\CandidateBookmark;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateSkill;
use App\Models\CandidateAward;
use App\Models\CandidateResume;
use App\Mail\WebsiteMail;
use Illuminate\Validation\Rule;
use Auth;
use Hash;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

// Define the CompanyController class
class CompanyController extends Controller
{
    // Function to show the dashboard of the company
    public function dashboard()
    {
        // Count the total number of opened jobs for the company
        $total_opened_jobs = Job::where('company_id', Auth::guard('company')->user()->id)->count();
        
        // Count the total number of featured jobs for the company
        $total_featured_jobs = Job::where('company_id', Auth::guard('company')->user()->id)->where('is_featured', 1)->count();

        // Fetch the last two jobs posted by the company along with their categories
        $jobs = Job::with('rJobCategory')->where('company_id', Auth::guard('company')->user()->id)->orderBy('id', 'desc')->take(2)->get();
        
        // Return the dashboard view with the retrieved data
        return view('company.dashboard', compact('jobs', 'total_opened_jobs', 'total_featured_jobs'));
    }

    // Function to show the orders of the company
    public function orders()
    {
        // Fetch all orders related to the company along with the associated package details
        $orders = Order::with('rPackage')->orderBy('id', 'desc')->where('company_id', Auth::guard('company')->user()->id)->get();
        
        // Return the orders view with the retrieved data
        return view('company.orders', compact('orders'));
    }

    // Function to show the edit profile form for the company
    public function edit_profile()
    {
        // Fetch all company locations, industries, and sizes to populate the form
        $company_locations = CompanyLocation::orderBy('name', 'asc')->get();
        $company_industries = CompanyIndustry::orderBy('name', 'asc')->get();
        $company_sizes = CompanySize::get();
        
        // Return the edit profile view with the retrieved data
        return view('company.edit_profile', compact('company_locations', 'company_industries', 'company_sizes'));
    }

    // Function to handle the profile update submission
    public function edit_profile_update(Request $request)
    {
        // Fetch the company object based on the authenticated user's ID
        $obj = Company::where('id', Auth::guard('company')->user()->id)->first();
        $id = $obj->id;

        // Validate the incoming request data
        $request->validate([
            'company_name' => 'required',
            'person_name' => 'required',
            'username' => ['required', 'alpha_dash', Rule::unique('companies')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('companies')->ignore($id)],
        ]);

        // Handle the logo upload if a new logo is provided
        if ($request->hasFile('logo')) {
            // Validate the logo file
            $request->validate([
                'logo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete the old logo if it exists
            if (Auth::guard('company')->user()->logo != '') {
                unlink(public_path('uploads/' . $obj->logo));
            }

            // Process the new logo
            $ext = $request->file('logo')->extension();
            $final_name = 'company_logo_' . time() . '.' . $ext;
            $request->file('logo')->move(public_path('uploads/'), $final_name);

            // Update the logo field in the company object
            $obj->logo = $final_name;
        }

        // Update the other company fields with the request data
        $obj->company_name = $request->company_name;
        $obj->person_name = $request->person_name;
        $obj->username = $request->username;
        $obj->email = $request->email;
        $obj->phone = $request->phone;
        $obj->address = $request->address;
        $obj->company_location_id = $request->company_location_id;
        $obj->company_industry_id = $request->company_industry_id;
        $obj->company_size_id = $request->company_size_id;
        $obj->founded_on = $request->founded_on;
        $obj->website = $request->website;
        $obj->description = $request->description;
        $obj->oh_mon = $request->oh_mon;
        $obj->oh_tue = $request->oh_tue;
        $obj->oh_wed = $request->oh_wed;
        $obj->oh_thu = $request->oh_thu;
        $obj->oh_fri = $request->oh_fri;
        $obj->oh_sat = $request->oh_sat;
        $obj->oh_sun = $request->oh_sun;
        $obj->map_code = $request->map_code;
        $obj->facebook = $request->facebook;
        $obj->twitter = $request->twitter;
        $obj->linkedin = $request->linkedin;
        $obj->instagram = $request->instagram;
        
        // Save the updated company object
        $obj->update();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile is updated successfully.');
    }

    // Function to show the edit password form for the company
    public function edit_password()
    {
        return view('company.edit_password');
    }

    // Function to handle the password update submission
    public function edit_password_update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        // Fetch the company object
        $obj = Company::where('id', Auth::guard('company')->user()->id)->first();
        
        // Hash the new password and save it
        $obj->password = Hash::make($request->password);
        $obj->update();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Password is updated successfully.');
    }

    // Function to show the photos section of the company
    public function photos()
    {
        // Check if the company has an active package
        $order_data = Order::where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();

        // If no active package, redirect back with an error
        if (!$order_data) {
            return redirect()->back()->with('error', 'You must have to buy a package first to access this page');
        }

        // Check if the current package allows access to the photo section
        $package_data = Package::where('id', $order_data->package_id)->first();
        if ($package_data->total_allowed_photos == 0) {
            return redirect()->back()->with('error', 'Your current package does not allow to access the photo section');
        }

        // Fetch all photos uploaded by the company
        $photos = CompanyPhoto::where('company_id', Auth::guard('company')->user()->id)->get();
        
        // Return the photos view with the retrieved data
        return view('company.photos', compact('photos'));
    }

    // Function to handle the photo upload submission
    public function photos_submit(Request $request)
    {
        // Fetch the current active order and package data
        $order_data = Order::where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();
        $package_data = Package::where('id', $order_data->package_id)->first();
        
        // Count existing photos uploaded by the company
        $existing_photo_number = CompanyPhoto::where('company_id', Auth::guard('company')->user()->id)->count();

        // Check if the maximum allowed photos have been uploaded
        if ($package_data->total_allowed_photos == $existing_photo_number) {
            return redirect()->back()->with('error', 'Maximum number of allowed photos are uploaded. So you have to upgrade your package if you want to add more photos.');
        }

        // Check if the package has expired
        if (date('Y-m-d') > $order_data->expire_date) {
            return redirect()->back()->with('error', 'Your package is expired!');
        }

        // Validate the incoming request for photo upload
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Create a new CompanyPhoto object
        $obj = new CompanyPhoto();

        // Process the uploaded photo file
        $ext = $request->file('photo')->extension();
        $final_name = 'company_photo_' . time() . '.' . $ext;
        $request->file('photo')->move(public_path('uploads/'), $final_name);

        // Save the photo information to the database
        $obj->photo = $final_name;
        $obj->company_id = Auth::guard('company')->user()->id;
        $obj->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Photo is uploaded successfully.');
    }

    // Function to delete a photo
    public function photos_delete($id)
    {
        // Fetch the photo object and delete the associated file
        $single_data = CompanyPhoto::where('id', $id)->first();
        unlink(public_path('uploads/' . $single_data->photo));
        
        // Delete the photo record from the database
        CompanyPhoto::where('id', $id)->delete();
        
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Photo is deleted successfully.');
    }

    // Function to show the videos section of the company
    public function videos()
    {
        // Check if the company has an active package
        $order_data = Order::where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();

        // If no active package, redirect back with an error
        if (!$order_data) {
            return redirect()->back()->with('error', 'You must have to buy a package first to access this page');
        }

        // Check if the current package allows access to the video section
        $package_data = Package::where('id', $order_data->package_id)->first();
        if ($package_data->total_allowed_videos == 0) {
            return redirect()->back()->with('error', 'Your current package does not allow to access the video section');
        }

        // Fetch all videos uploaded by the company
        $videos = CompanyVideo::where('company_id', Auth::guard('company')->user()->id)->get();
        
        // Return the videos view with the retrieved data
        return view('company.videos', compact('videos'));
    }

    // Function to handle the video upload submission
    public function videos_submit(Request $request)
    {
        // Fetch the current active order and package data
        $order_data = Order::where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();
        $package_data = Package::where('id', $order_data->package_id)->first();
        
        // Count existing videos uploaded by the company
        $existing_video_number = CompanyVideo::where('company_id', Auth::guard('company')->user()->id)->count();

        // Check if the maximum allowed videos have been uploaded
        if ($package_data->total_allowed_videos == $existing_video_number) {
            return redirect()->back()->with('error', 'Maximum number of allowed videos are uploaded. So you have to upgrade your package if you want to add more videos.');
        }

        // Check if the package has expired
        if (date('Y-m-d') > $order_data->expire_date) {
            return redirect()->back()->with('error', 'Your package is expired!');
        }

        // Validate the incoming request for video upload
        $request->validate([
            'video_id' => 'required'
        ]);

        // Create a new CompanyVideo object and save the video ID
        $obj = new CompanyVideo();
        $obj->company_id = Auth::guard('company')->user()->id;
        $obj->video_id = $request->video_id;
        $obj->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Video is uploaded successfully.');
    }

    // Function to delete a video
    public function videos_delete($id)
    {
        // Delete the video record from the database
        CompanyVideo::where('id', $id)->delete();
        
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Video is deleted successfully.');
    }

    // Function to show the make payment page
    public function make_payment()
    {
        // Fetch the current active plan of the company
        $current_plan = Order::with('rPackage')->where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();
        
        // Fetch all available packages for the company to choose from
        $packages = Package::get();
        
        // Return the make payment view with the retrieved data
        return view('company.make_payment', compact('current_plan', 'packages'));
    }

    // Function to handle PayPal payment submission
    public function paypal(Request $request)
    {
        // Fetch the selected package details
        $single_package_data = Package::where('id', $request->package_id)->first();
        
        // Create a new PayPal client and obtain an access token
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        // Create a new order for the payment
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('company_paypal_success'),
                "cancel_url" => route('company_paypal_cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $single_package_data->package_price
                    ]
                ]
            ]
        ]);

        // Check if the order was created successfully
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                // Redirect the user to the PayPal approval URL
                if ($link['rel'] === 'approve') {
                    session()->put('package_id', $single_package_data->id);
                    session()->put('package_price', $single_package_data->package_price);
                    session()->put('package_days', $single_package_data->package_days);

                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('company_paypal_cancel');
        }
    }

    // Function to handle successful PayPal payment
    public function paypal_success(Request $request)
    {
        // Create a new PayPal client and obtain an access token
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        
        // Capture the payment for the created order
        $response = $provider->capturePaymentOrder($request->token);

        // Check if the payment was successful
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Mark previous orders as inactive
            $data['currently_active'] = 0;
            Order::where('company_id', Auth::guard()->user()->id)->update($data);

            // Create a new order record for the payment
            $obj = new Order();
            $obj->company_id = Auth::guard()->user()->id;
            $obj->package_id = session()->get('package_id');
            $obj->order_no = time();
            $obj->paid_amount = session()->get('package_price');
            $obj->payment_method = 'PayPal';
            $obj->start_date = date('Y-m-d');
            $days = session()->get('package_days');
            $obj->expire_date = date('Y-m-d', strtotime("+$days days"));
            $obj->currently_active = 1;
            $obj->save();

            // Clear the session data
            session()->forget('package_id');
            session()->forget('package_price');
            session()->forget('package_days');

            // Redirect to payment page with a success message
            return redirect()->route('company_make_payment')->with('success', 'Payment is successful!');
        } else {
            return redirect()->route('company_paypal_cancel');
        }
    }

    // Function to handle PayPal payment cancellation
    public function paypal_cancel()
    {
        return redirect()->route('company_make_payment')->with('error', 'Payment is cancelled!');
    }

    // Function to handle Stripe payment submission
    public function stripe(Request $request)
    {
        // Fetch the selected package details
        $single_package_data = Package::where('id', $request->package_id)->first();

        // Set the Stripe API key and create a new checkout session
        \Stripe\Stripe::setApiKey(config('stripe.stripe_sk'));
        $response = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $single_package_data->package_name
                        ],
                        'unit_amount' => $single_package_data->package_price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('company_stripe_success'),
            'cancel_url' => route('company_stripe_cancel'),
        ]);

        // Store package details in the session
        session()->put('package_id', $single_package_data->id);
        session()->put('package_price', $single_package_data->package_price);
        session()->put('package_days', $single_package_data->package_days);

        // Redirect to the Stripe checkout page
        return redirect()->away($response->url);
    }

    // Function to handle successful Stripe payment
    public function stripe_success()
    {
        // Mark previous orders as inactive
        $data['currently_active'] = 0;
        Order::where('company_id', Auth::guard()->user()->id)->update($data);

        // Create a new order record for the payment
        $obj = new Order();
        $obj->company_id = Auth::guard()->user()->id;
        $obj->package_id = session()->get('package_id');
        $obj->order_no = time();
        $obj->paid_amount = session()->get('package_price');
        $obj->payment_method = 'Stripe';
        $obj->start_date = date('Y-m-d');
        $days = session()->get('package_days');
        $obj->expire_date = date('Y-m-d', strtotime("+$days days"));
        $obj->currently_active = 1;
        $obj->save();

        // Clear the session data
        session()->forget('package_id');
        session()->forget('package_price');
        session()->forget('package_days');

        // Redirect to payment page with a success message
        return redirect()->route('company_make_payment')->with('success', 'Payment is successful!');
    }

    // Function to handle Stripe payment cancellation
    public function stripe_cancel()
    {
        return redirect()->route('company_make_payment')->with('error', 'Payment is cancelled!');
    }

    // Function to show the create job page
    public function jobs_create()
    {
        // Check if the company has an active package
        $order_data = Order::where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();
        
        // If no active package, redirect back with an error
        if (!$order_data) {
            return redirect()->back()->with('error', 'You must have to buy a package first to access this page');
        }

        // Check if the package has expired
        if (date('Y-m-d') > $order_data->expire_date) {
            return redirect()->back()->with('error', 'Your package is expired!');
        }

        // Check if the current package allows posting jobs
        $package_data = Package::where('id', $order_data->package_id)->first();
        if ($package_data->total_allowed_jobs == 0) {
            return redirect()->back()->with('error', 'Your current package does not allow to access the job section');
        }

        // Count the total jobs posted by the company
        $total_jobs_posted = Job::where('company_id', Auth::guard('company')->user()->id)->count();
        if ($package_data->total_allowed_jobs == $total_jobs_posted) {
            return redirect()->back()->with('error', 'You already have posted the maximum number of allowed jobs');
        }

        // Fetch the job categories, locations, types, experiences, genders, and salary ranges to populate the form
        $job_categories = JobCategory::orderBy('name', 'asc')->get();
        $job_locations = JobLocation::orderBy('name', 'asc')->get();
        $job_types = JobType::orderBy('name', 'asc')->get();
        $job_experiences = JobExperience::orderBy('id', 'asc')->get();
        $job_genders = JobGender::orderBy('id', 'asc')->get();
        $job_salary_ranges = JobSalaryRange::orderBy('id', 'asc')->get();
        
        // Return the create job view with the retrieved data
        return view('company.jobs_create', compact('job_categories', 'job_locations', 'job_types', 'job_experiences', 'job_genders', 'job_salary_ranges'));
    }

    // Function to handle the job creation submission
    public function jobs_create_submit(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'vacancy' => 'required'
        ]);

        // Fetch the current active order and package data
        $order_data = Order::where('company_id', Auth::guard('company')->user()->id)->where('currently_active', 1)->first();
        $package_data = Package::where('id', $order_data->package_id)->first();

        // Check if the total allowed featured jobs have been posted
        $total_featured_jobs = Job::where('company_id', Auth::guard('company')->user()->id)->where('is_featured', 1)->count();
        if ($total_featured_jobs == $package_data->total_allowed_featured_jobs) {
            if ($request->is_featured == 1) {
                return redirect()->back()->with('error', 'You already have added the total number of featured jobs');
            }
        }

        // Create a new Job object and fill it with request data
        $obj = new Job();
        $obj->company_id = Auth::guard('company')->user()->id;
        $obj->title = $request->title;
        $obj->description = $request->description;
        $obj->responsibility = $request->responsibility;
        $obj->skill = $request->skill;
        $obj->education = $request->education;
        $obj->benefit = $request->benefit;
        $obj->deadline = $request->deadline;
        $obj->vacancy = $request->vacancy;
        $obj->job_category_id = $request->job_category_id;
        $obj->job_location_id = $request->job_location_id;
        $obj->job_type_id = $request->job_type_id;
        $obj->job_experience_id = $request->job_experience_id;
        $obj->job_gender_id = $request->job_gender_id;
        $obj->job_salary_range_id = $request->job_salary_range_id;
        $obj->map_code = $request->map_code;
        $obj->is_featured = $request->is_featured;
        $obj->is_urgent = $request->is_urgent;
        $obj->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Job is posted successfully!');
    }

    // Function to show all jobs posted by the company
    public function jobs()
    {
        // Fetch all jobs along with their categories posted by the company
        $jobs = Job::with('rJobCategory')->where('company_id', Auth::guard('company')->user()->id)->get();
        
        // Return the jobs view with the retrieved data
        return view('company.jobs', compact('jobs'));
    }

    // Function to show the edit job page
    public function jobs_edit($id)
    {
        // Fetch the specific job details to edit
        $jobs_single = Job::where('id', $id)->first();
        $job_categories = JobCategory::orderBy('name', 'asc')->get();
        $job_locations = JobLocation::orderBy('name', 'asc')->get();
        $job_types = JobType::orderBy('name', 'asc')->get();
        $job_experiences = JobExperience::orderBy('id', 'asc')->get();
        $job_genders = JobGender::orderBy('id', 'asc')->get();
        $job_salary_ranges = JobSalaryRange::orderBy('id', 'asc')->get();
        
        // Return the edit job view with the job data and options
        return view('company.jobs_edit', compact('jobs_single', 'job_categories', 'job_locations', 'job_types', 'job_experiences', 'job_genders', 'job_salary_ranges'));
    }

    // Function to handle the job update submission
    public function jobs_update(Request $request, $id)
    {
        // Fetch the job object to update
        $obj = Job::where('id', $id)->first();

        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'vacancy' => 'required'
        ]);

        // Update the job fields with the request data
        $obj->title = $request->title;
        $obj->description = $request->description;
        $obj->responsibility = $request->responsibility;
        $obj->skill = $request->skill;
        $obj->education = $request->education;
        $obj->benefit = $request->benefit;
        $obj->deadline = $request->deadline;
        $obj->vacancy = $request->vacancy;
        $obj->job_category_id = $request->job_category_id;
        $obj->job_location_id = $request->job_location_id;
        $obj->job_type_id = $request->job_type_id;
        $obj->job_experience_id = $request->job_experience_id;
        $obj->job_gender_id = $request->job_gender_id;
        $obj->job_salary_range_id = $request->job_salary_range_id;
        $obj->map_code = $request->map_code;
        $obj->is_featured = $request->is_featured;
        $obj->is_urgent = $request->is_urgent;
        
        // Save the updated job object
        $obj->update();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Job is updated successfully!');
    }

    // Function to delete a job
    public function jobs_delete($id)
    {
        // Delete the job object and any associated applications and bookmarks
        Job::where('id', $id)->delete();
        CandidateApplication::where('job_id', $id)->delete();
        CandidateBookmark::where('job_id', $id)->delete();

        // Redirect to the jobs list with a success message
        return redirect()->route('company_jobs')->with('success', 'Job is deleted successfully.');
    }

    // Function to show all applications for jobs posted by the company
    public function candidate_applications()
    {
        // Fetch all jobs along with their details posted by the company
        $jobs = Job::with('rJobCategory', 'rJobLocation', 'rJobType', 'rJobGender', 'rJobExperience', 'rJobSalaryRange')->where('company_id', Auth::guard('company')->user()->id)->get();
        
        // Return the applications view with the retrieved jobs
        return view('company.applications', compact('jobs'));
    }

    // Function to show applicants for a specific job
    public function applicants($id)
    {
        // Fetch all applicants for the specific job
        $applicants = CandidateApplication::with('rCandidate')->where('job_id', $id)->get();
        $job_single = Job::where('id', $id)->first();

        // Return the applicants view with the retrieved applicants and job details
        return view('company.applicants', compact('applicants', 'job_single'));
    }

    // Function to show the resume of a specific applicant
    public function applicant_resume($id)
    {
        // Fetch the candidate's information along with their education, experience, skills, awards, and resumes
        $candidate_single = Candidate::where('id', $id)->first();
        $candidate_educations = CandidateEducation::where('candidate_id', $id)->get();
        $candidate_experiences = CandidateExperience::where('candidate_id', $id)->get();
        $candidate_skills = CandidateSkill::where('candidate_id', $id)->get();
        $candidate_awards = CandidateAward::where('candidate_id', $id)->get();
        $candidate_resumes = CandidateResume::where('candidate_id', $id)->get();

        // Return the applicant resume view with the retrieved data
        return view('company.applicant_resume', compact('candidate_single', 'candidate_educations', 'candidate_experiences', 'candidate_skills', 'candidate_awards', 'candidate_resumes'));
    }

    // Function to change the status of a job application
    public function application_status_change(Request $request)
    {
        // Fetch the candidate application object to update
        $obj = CandidateApplication::with('rCandidate')->where('candidate_id', $request->candidate_id)->where('job_id', $request->job_id)->first();
        
        // Update the status of the application
        $obj->status = $request->status;
        $obj->update();

        // Get the candidate's email address for notification
        $candidate_email = $obj->rCandidate->email;

        // If the application is approved, send an email to the candidate
        if ($request->status == 'Approved') {
            // Generate the detail link for the candidate's application
            $detail_link = route('candidate_applications');
            $subject = 'Congratulation! Your application is approved';
            $message = 'Please check the detail: <br>';
            $message .= '<a href="' . $detail_link . '">Click here to see the detail</a>';

            // Send the email
            \Mail::to($candidate_email)->send(new WebsiteMail($subject, $message));
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Status is changed successfully!');
    }
}
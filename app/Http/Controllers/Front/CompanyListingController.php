<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Company;
use App\Models\CompanyIndustry;
use App\Models\CompanyLocation;
use App\Models\CompanySize;
use App\Models\CompanyPhoto;
use App\Models\CompanyVideo;
use App\Models\Advertisement;
use App\Models\PageOtherItem;
use App\Models\Order;
use App\Mail\Websitemail;

class CompanyListingController extends Controller
{
    // Displays the list of companies on the company listing page, with options for filtering
    public function index(Request $request)
    {
        // Step 1: Retrieve data for filter options.
        // Fetch all company industries, locations, and sizes from the database, sorted by name or ID
        // These are used in dropdowns for filtering companies on the listing page
        $company_industries = CompanyIndustry::orderBy('name', 'asc')->get();
        $company_locations = CompanyLocation::orderBy('name', 'asc')->get();
        $company_sizes = CompanySize::orderBy('id', 'asc')->get();

        // Step 2: Retrieve filter input values from the request, or null if they aren't provided.
        // These variables hold the user-selected filter criteria and are used to build the query
        $form_name = $request->name;
        $form_industry = $request->industry;
        $form_location = $request->location;
        $form_size = $request->size;
        $form_founded = $request->founded;

        // Step 3: Start building the query for companies.
        // Use Eloquent relationships to count jobs and load related industry, location, and size data for each company
        $companies = Company::withCount('rJob')
                            ->with('rCompanyIndustry', 'rCompanyLocation', 'rCompanySize')
                            ->orderBy('id', 'desc'); // Sort companies in descending order by ID (newest first)

        // Step 4: Apply filters to the company query based on user input.
        if ($request->name != null) {
            // Filter by company name using a partial match (LIKE) to find names that include the input value
            $companies = $companies->where('company_name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->industry != null) {
            // Filter by exact match on company industry ID
            $companies = $companies->where('company_industry_id', $request->industry);
        }

        if ($request->location != null) {
            // Filter by exact match on company location ID
            $companies = $companies->where('company_location_id', $request->location);
        }

        if ($request->size != null) {
            // Filter by exact match on company size ID
            $companies = $companies->where('company_size_id', $request->size);
        }

        if ($request->founded != null) {
            // Filter by founding year, matching exactly with the user input
            $companies = $companies->where('founded_on', $request->founded);
        }

        // Step 5: Paginate the results.
        // This splits the results into pages, displaying 9 companies per page
        $companies = $companies->paginate(9);

        // Step 6: Retrieve additional content for the listing page.
        // Get advertisement and other page settings to display alongside the listing
        $advertisement_data = Advertisement::where('id', 1)->first();
        $other_page_item = PageOtherItem::where('id', 1)->first();

        // Step 7: Pass all necessary data to the view for rendering.
        // This includes the companies, filter options, form input values, and additional page content
        return view('front.company_listing', compact('companies', 'company_industries', 'company_locations', 'company_sizes', 'form_name', 'form_industry', 'form_location', 'form_size', 'form_founded', 'advertisement_data', 'other_page_item'));
    }

    // Displays detailed information about a specific company, including jobs, photos, and videos
    public function detail($id)
    {
        // Step 1: Check for an active subscription for the company.
        // Retrieve the company's active order. If no active order is found or it has expired, redirect to the home page
        $order_data = Order::where('company_id', $id)->where('currently_active', 1)->first();
        if (date('Y-m-d') > $order_data->expire_date) {
            return redirect()->route('home'); // Redirect if the order has expired
        }

        // Step 2: Fetch the company details and related data.
        // This loads the company's industry, location, size, and job count in a single query
        $company_single = Company::withCount('rJob')
                                 ->with('rCompanyIndustry', 'rCompanyLocation', 'rCompanySize')
                                 ->where('id', $id)
                                 ->first();

        // Step 3: Load associated photos if available, or set as an empty string if not.
        // Check for existence of photos for the company, and fetch them if they exist
        if (CompanyPhoto::where('company_id', $company_single->id)->exists()) {
            $company_photos = CompanyPhoto::where('company_id', $company_single->id)->get();
        } else {
            $company_photos = ''; // No photos available
        }

        // Step 4: Load associated videos if available, or set as an empty string if not.
        // Check for existence of videos for the company, and fetch them if they exist
        if (CompanyVideo::where('company_id', $company_single->id)->exists()) {
            $company_videos = CompanyVideo::where('company_id', $company_single->id)->get();
        } else {
            $company_videos = ''; // No videos available
        }

        // Step 5: Retrieve job listings associated with this company.
        // Loads related data for each job, including category, location, type, experience level, gender, and salary range
        $jobs = Job::with('rJobCategory', 'rJobLocation', 'rJobType', 'rJobExperience', 'rJobGender', 'rJobSalaryRange')
                   ->where('company_id', $company_single->id)
                   ->get();

        // Step 6: Fetch additional page content for the company detail page.
        $other_page_item = PageOtherItem::where('id', 1)->first();

        // Step 7: Pass all the data to the view.
        // This includes the company details, photos, videos, jobs, and page content for rendering the company detail page
        return view('front.company', compact('company_single', 'company_photos', 'company_videos', 'jobs', 'other_page_item'));
    }

    // Handles sending an email through the contact form on the company page
    public function send_email(Request $request)
    {
        // Step 1: Validate the contact form input fields.
        // Ensure visitor's name, email, and message are provided and properly formatted
        $request->validate([
            'visitor_name' => 'required',
            'visitor_email' => 'required|email',
            'visitor_message' => 'required'
        ]);

        // Step 2: Construct the email content with visitor details.
        // Include the visitor's name, email, phone, and message content in the email body
        $subject = 'Contact Form Message';
        $message = 'Visitor Information: <br>';
        $message .= 'Name: ' . $request->visitor_name . '<br>';
        $message .= 'Email: ' . $request->visitor_email . '<br>';
        $message .= 'Phone: ' . $request->visitor_phone . '<br>';
        $message .= 'Message: ' . $request->visitor_message;

        // Step 3: Send the email using Laravel's Mail facade.
        // The Websitemail Mailable class is used to send the email to the recipient specified by `receive_email`
        \Mail::to($request->receive_email)->send(new Websitemail($subject, $message));

        // Step 4: Redirect back to the form page with a success message.
        // The message confirms that the email was sent successfully
        return redirect()->back()->with('success', 'Email is sent successfully!');
    }
}
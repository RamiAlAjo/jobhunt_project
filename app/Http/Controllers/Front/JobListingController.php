<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\JobType;
use App\Models\JobExperience;
use App\Models\JobGender;
use App\Models\JobSalaryRange;
use App\Models\Advertisement;
use App\Models\PageOtherItem;
use App\Mail\Websitemail;

/**
 * Purpose: This controller handles the job listing and detail functionalities.
 * It allows users to view, filter, and search for jobs based on various criteria.
 * It also provides functionality for viewing detailed job information and sending 
 * job inquiries via email.
 */
class JobListingController extends Controller
{
    /**
     * Displays the job listing page with filtering options.
     * Retrieves all jobs with filterable attributes such as categories, locations, types, etc.
     *
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Retrieve filter options for the job search page
        $job_categories = JobCategory::orderBy('name', 'asc')->get();
        $job_locations = JobLocation::orderBy('name', 'asc')->get();
        $job_types = JobType::orderBy('name', 'asc')->get();
        $job_experiences = JobExperience::orderBy('id', 'asc')->get();
        $job_genders = JobGender::orderBy('id', 'asc')->get();
        $job_salary_ranges = JobSalaryRange::orderBy('id', 'asc')->get();

        // Store filter values from the request
        $form_title = $request->title;
        $form_category = $request->category;
        $form_location = $request->location;
        $form_type = $request->type;
        $form_experience = $request->experience;
        $form_gender = $request->gender;
        $form_salary_range = $request->salary_range;

        // Retrieve all jobs and include related models for detailed information
        $jobs = Job::with(
            'rCompany', 
            'rJobCategory', 
            'rJobLocation', 
            'rJobType', 
            'rJobExperience', 
            'rJobGender', 
            'rJobSalaryRange'
        )->orderBy('id', 'desc');

        // Apply filters based on user input
        if ($request->title != null) {
            $jobs = $jobs->where('title', 'LIKE', '%' . $request->title . '%');
        }
        if ($request->category != null) {
            $jobs = $jobs->where('job_category_id', $request->category);
        }
        if ($request->location != null) {
            $jobs = $jobs->where('job_location_id', $request->location);
        }
        if ($request->type != null) {
            $jobs = $jobs->where('job_type_id', $request->type);
        }
        if ($request->experience != null) {
            $jobs = $jobs->where('job_experience_id', $request->experience);
        }
        if ($request->gender != null) {
            $jobs = $jobs->where('job_gender_id', $request->gender);
        }
        if ($request->salary_range != null) {
            $jobs = $jobs->where('job_salary_range_id', $request->salary_range);
        }

        // Paginate the filtered job results to show 9 jobs per page
        $jobs = $jobs->paginate(9);

        // Retrieve additional data for the page, such as advertisements and page settings
        $advertisement_data = Advertisement::where('id', 1)->first();
        $other_page_item = PageOtherItem::where('id', 1)->first();

        // Pass all data to the job listing view
        return view('front.job_listing', compact(
            'jobs', 
            'job_categories', 
            'job_locations', 
            'job_types', 
            'job_experiences', 
            'job_genders', 
            'job_salary_ranges', 
            'form_title', 
            'form_category', 
            'form_location', 
            'form_type', 
            'form_experience', 
            'form_gender', 
            'form_salary_range', 
            'advertisement_data', 
            'other_page_item'
        ));
    }

    /**
     * Displays the detailed page for a specific job.
     * Fetches the job details and similar jobs within the same category.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {        
        // Retrieve the job details and associated data using relationships
        $job_single = Job::with(
            'rCompany', 
            'rJobCategory', 
            'rJobLocation', 
            'rJobType', 
            'rJobExperience', 
            'rJobGender', 
            'rJobSalaryRange'
        )->where('id', $id)->first();

        // Fetch similar jobs within the same category
        $jobs = Job::with(
            'rCompany', 
            'rJobCategory', 
            'rJobLocation', 
            'rJobType', 
            'rJobExperience', 
            'rJobGender', 
            'rJobSalaryRange'
        )->where('job_category_id', $job_single->job_category_id)->take(2)->get();

        // Retrieve other page settings
        $other_page_item = PageOtherItem::where('id', 1)->first();

        // Pass job details and similar jobs to the job detail view
        return view('front.job', compact('job_single', 'jobs', 'other_page_item'));
    }

    /**
     * Sends an email inquiry for a specific job listing.
     * Validates and sends the user's message to the recipient.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send_email(Request $request)
    {
        // Validate the email inquiry form fields
        $request->validate([
            'visitor_name' => 'required',
            'visitor_email' => 'required|email',
            'visitor_message' => 'required'
        ]);

        // Construct the email message with visitor's information
        $subject = 'Enquiry for job: ' . $request->job_title;
        $message = 'Visitor Information: <br>';
        $message .= 'Name: ' . $request->visitor_name . '<br>';
        $message .= 'Email: ' . $request->visitor_email . '<br>';
        $message .= 'Phone: ' . $request->visitor_phone . '<br>';
        $message .= 'Message: ' . $request->visitor_message;

        // Send the email to the job listing owner or contact person
        \Mail::to($request->receive_email)->send(new Websitemail($subject, $message));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Email is sent successfully!');
    }
}
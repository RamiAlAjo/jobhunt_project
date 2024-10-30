<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyPhoto;
use App\Models\CompanyVideo;
use App\Models\Job;
use App\Models\CandidateApplication;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateSkill;
use App\Models\CandidateAward;
use App\Models\CandidateResume;
use App\Models\Order;
use App\Models\CandidateBookmark;

// Define the AdminCompanyController class to manage company-related actions in the admin panel
class AdminCompanyController extends Controller
{
    // Display a list of active companies
    public function index()
    {
        // Retrieve companies where status is active (1)
        $companies = Company::where('status',1)->get();
        
        // Return the 'admin.companies' view, passing the list of active companies
        return view('admin.companies', compact('companies'));
    }

    // Display detailed information about a specific company
    public function companies_detail($id)
    {
        // Retrieve company details including related location, industry, and size data
        $companies_detail = Company::with('rCompanyLocation','rCompanyIndustry','rCompanySize')->where('id',$id)->first();
        
        // Retrieve all photos and videos associated with the company
        $photos = CompanyPhoto::where('company_id',$id)->get();
        $videos = CompanyVideo::where('company_id',$id)->get();
        
        // Return the 'admin.companies_detail' view with company details, photos, and videos
        return view('admin.companies_detail', compact('companies_detail','photos','videos'));
    }

    // Display jobs offered by a specific company
    public function companies_jobs($id)
    {
        // Retrieve company details and all jobs posted by this company
        $companies_detail = Company::where('id',$id)->first();
        $companies_jobs = Job::with('rJobCategory','rJobLocation')->where('company_id',$id)->get();
        
        // Return the 'admin.companies_jobs' view with job listings and company details
        return view('admin.companies_jobs', compact('companies_jobs','companies_detail'));
    }

    // Display applicants for a specific job posted by a company
    public function companies_applicants($id)
    {
        // Retrieve job details and all applicants who applied for this job
        $job_detail = Job::where('id',$id)->first();
        $applicants = CandidateApplication::with('rCandidate')->where('job_id',$id)->get();
        
        // Return the 'admin.companies_applicants' view with applicants and job details
        return view('admin.companies_applicants', compact('applicants','job_detail'));
    }

    // Display the resume and profile details of a specific applicant
    public function companies_applicant_resume($id)
    {
        // Retrieve candidate details along with their education, experience, skills, awards, and resumes
        $candidate_single = Candidate::where('id',$id)->first();
        $candidate_educations = CandidateEducation::where('candidate_id',$id)->get();
        $candidate_experiences = CandidateExperience::where('candidate_id',$id)->get();
        $candidate_skills = CandidateSkill::where('candidate_id',$id)->get();
        $candidate_awards = CandidateAward::where('candidate_id',$id)->get();
        $candidate_resumes = CandidateResume::where('candidate_id',$id)->get();

        // Return the 'admin.companies_applicant_resume' view with candidate details and resumes
        return view('admin.companies_applicant_resume', compact('candidate_single','candidate_educations','candidate_experiences','candidate_skills','candidate_awards','candidate_resumes'));
    }

    // Delete a company and all its associated data
    public function delete($id)
    {
        // Retrieve and delete all photos associated with the company from the server
        $company_photos = CompanyPhoto::where('company_id',$id)->get();
        foreach($company_photos as $item) {
            unlink(public_path('uploads/'.$item->photo));
        }
        CompanyPhoto::where('company_id',$id)->delete();

        // Delete all videos associated with the company
        CompanyVideo::where('company_id',$id)->delete();

        // Retrieve and delete all jobs and related applications and bookmarks associated with the company
        $jobs_list = Job::where('company_id',$id)->get();
        foreach($jobs_list as $item) {
            CandidateApplication::where('job_id',$item->id)->delete();
            CandidateBookmark::where('job_id',$item->id)->delete();
        }
        Job::where('company_id',$id)->delete();

        // Delete all orders associated with the company
        Order::where('company_id',$id)->delete();

        // Retrieve and delete the company logo from the server, if it exists
        $company_data = Company::where('id',$id)->first();
        if($company_data->logo != null) {
            unlink(public_path('uploads/'.$company_data->logo));
        }

        // Delete the company record
        Company::where('id',$id)->delete();

        // Redirect back with a success message after successful deletion
        return redirect()->back()->with('success', 'Data is deleted successfully.');
    }
}
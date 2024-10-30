<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateSkill;
use App\Models\CandidateAward;
use App\Models\CandidateResume;
use App\Models\CandidateApplication;
use App\Models\CandidateBookmark;

// Define the AdminCandidateController class to handle candidate-related actions in the admin panel
class AdminCandidateController extends Controller
{
    // Display a list of candidates with an active status
    public function index()
    {
        // Retrieve candidates where status is active (1)
        $candidates = Candidate::where('status',1)->get();
        
        // Return the 'admin.candidates' view, passing the list of active candidates
        return view('admin.candidates', compact('candidates'));
    }

    // Display details for a specific candidate
    public function candidates_detail($id)
    {
        // Retrieve candidate details along with their associated education, experience, skills, awards, and resumes
        $candidate_single = Candidate::where('id',$id)->first();
        $candidate_educations = CandidateEducation::where('candidate_id',$id)->get();
        $candidate_experiences = CandidateExperience::where('candidate_id',$id)->get();
        $candidate_skills = CandidateSkill::where('candidate_id',$id)->get();
        $candidate_awards = CandidateAward::where('candidate_id',$id)->get();
        $candidate_resumes = CandidateResume::where('candidate_id',$id)->get();

        // Return the 'admin.candidates_detail' view, passing candidate details and related data
        return view('admin.candidates_detail', compact('candidate_single','candidate_educations','candidate_experiences','candidate_skills','candidate_awards','candidate_resumes'));
    }

    // Display a list of jobs that a candidate has applied for
    public function candidates_applied_jobs($id)
    {
        // Retrieve applications for the candidate, including related job data
        $applications = CandidateApplication::with('rJob')->where('candidate_id',$id)->get();
        
        // Return the 'admin.candidates_applied_jobs' view, passing the candidate's applications
        return view('admin.candidates_applied_jobs',compact('applications'));
    }

    // Delete a candidate and all their associated data
    public function delete($id)
    {
        // Delete all candidate's applications, bookmarks, educations, experiences, awards, and skills by candidate ID
        CandidateApplication::where('candidate_id',$id)->delete();
        CandidateBookmark::where('candidate_id',$id)->delete();
        CandidateEducation::where('candidate_id',$id)->delete();
        CandidateExperience::where('candidate_id',$id)->delete();
        CandidateAward::where('candidate_id',$id)->delete();
        CandidateSkill::where('candidate_id',$id)->delete();

        // Retrieve and delete candidate's resume files from the server
        $resume_data = CandidateResume::where('candidate_id',$id)->get();
        foreach($resume_data as $item) {
            unlink(public_path('uploads/'.$item->file));
        }
        CandidateResume::where('candidate_id',$id)->delete();

        // Retrieve and delete candidate's profile photo from the server if it exists
        $candidate_data = Candidate::where('id',$id)->first();
        if($candidate_data->photo != null) {
            unlink(public_path('uploads/'.$candidate_data->photo));
        }
        
        // Delete the candidate record
        Candidate::where('id',$id)->delete();

        // Redirect back with a success message upon successful deletion
        return redirect()->back()->with('success', 'Data is deleted successfully.');
    }
}
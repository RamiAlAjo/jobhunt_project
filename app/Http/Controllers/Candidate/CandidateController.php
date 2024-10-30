<?php


// Table of Contents

// ### Candidate Controller
// 1. **Namespace and Imports**
//    - Declares the namespace and imports necessary classes and models.

// 2. **Class Declaration**
//    - `CandidateController` class extending the base Controller.

// 3. **Dashboard Methods**
//    - **`dashboard()`**
//      - Calculates and displays total applied, approved, and rejected jobs for the candidate.

// 4. **Profile Edit Methods**
//    - **`edit_profile()`**
//      - Displays the profile edit form.
//    - **`edit_profile_update(Request $request)`**
//      - Validates and updates the candidate's profile data.

// 5. **Password Edit Methods**
//    - **`edit_password()`**
//      - Displays the password edit form.
//    - **`edit_password_update(Request $request)`**
//      - Validates and updates the candidate's password.

// 6. **Education Management Methods**
//    - **`education()`**
//      - Displays the candidate's education history.
//    - **`education_create()`**
//      - Displays the form to add new education.
//    - **`education_store(Request $request)`**
//      - Validates and stores new education.
//    - **`education_edit($id)`**
//      - Displays the form to edit education.
//    - **`education_update(Request $request, $id)`**
//      - Validates and updates education data.
//    - **`education_delete($id)`**
//      - Deletes the specified education entry.

// 7. **Skill Management Methods**
//    - **`skill()`**
//      - Displays the candidate's skills.
//    - **`skill_create()`**
//      - Displays the form to add a new skill.
//    - **`skill_store(Request $request)`**
//      - Validates and stores a new skill.
//    - **`skill_edit($id)`**
//      - Displays the form to edit a skill.
//    - **`skill_update(Request $request, $id)`**
//      - Validates and updates skill data.
//    - **`skill_delete($id)`**
//      - Deletes the specified skill entry.

// 8. **Experience Management Methods**
//    - **`experience()`**
//      - Displays the candidate's work experience.
//    - **`experience_create()`**
//      - Displays the form to add new experience.
//    - **`experience_store(Request $request)`**
//      - Validates and stores new experience.
//    - **`experience_edit($id)`**
//      - Displays the form to edit experience.
//    - **`experience_update(Request $request, $id)`**
//      - Validates and updates experience data.
//    - **`experience_delete($id)`**
//      - Deletes the specified experience entry.

// 9. **Award Management Methods**
//    - **`award()`**
//      - Displays the candidate's awards.
//    - **`award_create()`**
//      - Displays the form to add a new award.
//    - **`award_store(Request $request)`**
//      - Validates and stores a new award.
//    - **`award_edit($id)`**
//      - Displays the form to edit an award.
//    - **`award_update(Request $request, $id)`**
//      - Validates and updates award data.
//    - **`award_delete($id)`**
//      - Deletes the specified award entry.

// 10. **Resume Management Methods**
//     - **`resume()`**
//       - Displays the candidate's resumes.
//     - **`resume_create()`**
//       - Displays the form to add a new resume.
//     - **`resume_store(Request $request)`**
//       - Validates and stores a new resume.
//     - **`resume_edit($id)`**
//       - Displays the form to edit a resume.
//     - **`resume_update(Request $request, $id)`**
//       - Validates and updates resume data.
//     - **`resume_delete($id)`**
//       - Deletes the specified resume entry.

// 11. **Bookmark Management Methods**
//     - **`bookmark_add($id)`**
//       - Adds a job to the candidate's bookmarks.
//     - **`bookmark_view()`**
//       - Displays all bookmarked jobs.
//     - **`bookmark_delete($id)`**
//       - Deletes a bookmark.

// 12. **Job Application Methods**
//     - **`apply($id)`**
//       - Displays the application form for a job.
//     - **`apply_submit(Request $request, $id)`**
//       - Validates and submits the job application.
//     - **`applications()`**
//       - Displays all job applications made by the candidate.

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateSkill;
use App\Models\CandidateExperience;
use App\Models\CandidateAward;
use App\Models\CandidateResume;
use App\Models\CandidateBookmark;
use App\Models\CandidateApplication;
use App\Mail\WebsiteMail;
use Illuminate\Validation\Rule;
use Hash;
use Auth;

class CandidateController extends Controller
{
    // Show candidate dashboard with applied, approved, and rejected job stats
    public function dashboard()
    {
        // Initializing job counters
        $total_applied_jobs = 0;
        $total_rejected_jobs = 0;
        $total_approved_jobs = 0;

        // Fetch counts of different application statuses
        $total_applied_jobs = CandidateApplication::where('candidate_id', Auth::guard('candidate')->user()->id)
            ->where('status', 'Applied')->count();
        $total_rejected_jobs = CandidateApplication::where('candidate_id', Auth::guard('candidate')->user()->id)
            ->where('status', 'Rejected')->count();
        $total_approved_jobs = CandidateApplication::where('candidate_id', Auth::guard('candidate')->user()->id)
            ->where('status', 'Approved')->count();

        return view('candidate.dashboard', compact('total_applied_jobs', 'total_rejected_jobs', 'total_approved_jobs'));
    }

    // Show profile edit form
    public function edit_profile()
    {
        return view('candidate.edit_profile');
    }

    // Update candidate profile
    public function edit_profile_update(Request $request)
    {
        // Fetch current candidate data
        $obj = Candidate::where('id', Auth::guard('candidate')->user()->id)->first();
        $id = $obj->id;

        // Validate form inputs with unique checks for username and email
        $request->validate([
            'name' => 'required',
            'username' => ['required', 'alpha_dash', Rule::unique('candidates')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('candidates')->ignore($id)],
        ]);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $request->validate(['photo' => 'image|mimes:jpg,jpeg,png,gif']);
            if (Auth::guard('candidate')->user()->photo != '') {
                unlink(public_path('uploads/' . $obj->photo));
            }
            $ext = $request->file('photo')->extension();
            $final_name = 'candidate_photo_' . time() . '.' . $ext;
            $request->file('photo')->move(public_path('uploads/'), $final_name);
            $obj->photo = $final_name;
        }

        // Update candidate details and save
        $obj->name = $request->name;
        $obj->designation = $request->designation;
        $obj->username = $request->username;
        $obj->email = $request->email;
        $obj->biography = $request->biography;
        $obj->phone = $request->phone;
        $obj->country = $request->country;
        $obj->address = $request->address;
        $obj->state = $request->state;
        $obj->city = $request->city;
        $obj->zip_code = $request->zip_code;
        $obj->gender = $request->gender;
        $obj->marital_status = $request->marital_status;
        $obj->date_of_birth = $request->date_of_birth;
        $obj->website = $request->website;
        $obj->update();

        return redirect()->back()->with('success', 'Profile is updated successfully.');
    }

    // Show form to change password
    public function edit_password()
    {
        return view('candidate.edit_password');
    }

    // Update candidate password
    public function edit_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        // Hash and save the new password
        $obj = Candidate::where('id', Auth::guard('candidate')->user()->id)->first();
        $obj->password = Hash::make($request->password);
        $obj->update();

        return redirect()->back()->with('success', 'Password is updated successfully.');
    }

    // Display candidate education list
    public function education()
    {
        $educations = CandidateEducation::where('candidate_id', Auth::guard('candidate')->user()->id)->orderBy('id', 'desc')->get();
        return view('candidate.education', compact('educations'));
    }

    // Show form to create education record
    public function education_create()
    {
        return view('candidate.education_create');
    }

    // Store new education record
    public function education_store(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'institute' => 'required',
            'degree' => 'required',
            'passing_year' => 'required'
        ]);

        $obj = new CandidateEducation();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->level = $request->level;
        $obj->institute = $request->institute;
        $obj->degree = $request->degree;
        $obj->passing_year = $request->passing_year;
        $obj->save();

        return redirect()->route('candidate_education')->with('success', 'Education is added successfully.');
    }

    // Show form to edit an education record
    public function education_edit($id)
    {
        $education_single = CandidateEducation::where('id', $id)->first();
        return view('candidate.education_edit', compact('education_single'));
    }

    // Update education record
    public function education_update(Request $request, $id)
    {
        $obj = CandidateEducation::where('id', $id)->first();
        $request->validate([
            'level' => 'required',
            'institute' => 'required',
            'degree' => 'required',
            'passing_year' => 'required'
        ]);

        $obj->level = $request->level;
        $obj->institute = $request->institute;
        $obj->degree = $request->degree;
        $obj->passing_year = $request->passing_year;
        $obj->update();

        return redirect()->route('candidate_education')->with('success', 'Education is updated successfully.');
    }

    // Delete education record
    public function education_delete($id)
    {
        CandidateEducation::where('id', $id)->delete();
        return redirect()->route('candidate_education')->with('success', 'Education is deleted successfully.');
    }

    // Fetch and show candidate skills
    public function skill()
    {
        $skills = CandidateSkill::where('candidate_id', Auth::guard('candidate')->user()->id)->get();
        return view('candidate.skill', compact('skills'));
    }

    // Show form to add a new skill
    public function skill_create()
    {
        return view('candidate.skill_create');
    }

    // Store new skill record
    public function skill_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'percentage' => 'required'
        ]);

        $obj = new CandidateSkill();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->name = $request->name;
        $obj->percentage = $request->percentage;
        $obj->save();

        return redirect()->route('candidate_skill')->with('success', 'Skill is added successfully.');
    }

    // Show form to edit a skill
    public function skill_edit($id)
    {
        $skill_single = CandidateSkill::where('id', $id)->first();
        return view('candidate.skill_edit', compact('skill_single'));
    }

    // Update skill record
    public function skill_update(Request $request, $id)
    {
        $obj = CandidateSkill::where('id', $id)->first();
        $request->validate([
            'name' => 'required',
            'percentage' => 'required'
        ]);

        $obj->name = $request->name;
        $obj->percentage = $request->percentage;
        $obj->update();

        return redirect()->route('candidate_skill')->with('success', 'Skill is updated successfully.');
    }

    // Delete skill record
    public function skill_delete($id)
    {
        CandidateSkill::where('id', $id)->delete();
        return redirect()->route('candidate_skill')->with('success', 'Skill is deleted successfully.');
    }

    // Fetch and show candidate experiences
    public function experience()
    {
        $experiences = CandidateExperience::where('candidate_id', Auth::guard('candidate')->user()->id)->orderBy('id', 'desc')->get();
        return view('candidate.experience', compact('experiences'));
    }

    // Show form to create experience record
    public function experience_create()
    {
        return view('candidate.experience_create');
    }

    // Store new experience record
    public function experience_store(Request $request)
    {
        $request->validate([
            'company' => 'required',
            'designation' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $obj = new CandidateExperience();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->company = $request->company;
        $obj->designation = $request->designation;
        $obj->start_date = $request->start_date;
        $obj->end_date = $request->end_date;
        $obj->save();

        return redirect()->route('candidate_experience')->with('success', 'Experience is added successfully.');
    }

    // Show form to edit experience record
    public function experience_edit($id)
    {
        $experience_single = CandidateExperience::where('id', $id)->first();
        return view('candidate.experience_edit', compact('experience_single'));
    }

    // Update experience record
    public function experience_update(Request $request, $id)
    {
        $obj = CandidateExperience::where('id', $id)->first();
        $request->validate([
            'company' => 'required',
            'designation' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $obj->company = $request->company;
        $obj->designation = $request->designation;
        $obj->start_date = $request->start_date;
        $obj->end_date = $request->end_date;
        $obj->update();

        return redirect()->route('candidate_experience')->with('success', 'Experience is updated successfully.');
    }

    // Delete experience record
    public function experience_delete($id)
    {
        CandidateExperience::where('id', $id)->delete();
        return redirect()->route('candidate_experience')->with('success', 'Experience is deleted successfully.');
    }

    // Fetch and show candidate awards
    public function award()
    {
        $awards = CandidateAward::where('candidate_id', Auth::guard('candidate')->user()->id)->orderBy('id', 'desc')->get();
        return view('candidate.award', compact('awards'));
    }

    // Show form to create award record
    public function award_create()
    {
        return view('candidate.award_create');
    }

    // Store new award record
    public function award_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $obj = new CandidateAward();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->title = $request->title;
        $obj->description = $request->description;
        $obj->date = $request->date;
        $obj->save();

        return redirect()->route('candidate_award')->with('success', 'Award is added successfully.');
    }

    // Show form to edit award record
    public function award_edit($id)
    {
        $award_single = CandidateAward::where('id', $id)->first();
        return view('candidate.award_edit', compact('award_single'));
    }

    // Update award record
    public function award_update(Request $request, $id)
    {
        $obj = CandidateAward::where('id', $id)->first();
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $obj->title = $request->title;
        $obj->description = $request->description;
        $obj->date = $request->date;
        $obj->update();

        return redirect()->route('candidate_award')->with('success', 'Award is updated successfully.');
    }

    // Delete award record
    public function award_delete($id)
    {
        CandidateAward::where('id', $id)->delete();
        return redirect()->route('candidate_award')->with('success', 'Award is deleted successfully.');
    }

    // Fetch and show candidate resumes
    public function resume()
    {
        $resumes = CandidateResume::where('candidate_id', Auth::guard('candidate')->user()->id)->get();
        return view('candidate.resume', compact('resumes'));
    }

    // Show form to create resume
    public function resume_create()
    {
        return view('candidate.resume_create');
    }

    // Store new resume
    public function resume_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required|mimes:pdf,doc,docx'
        ]);

        $ext = $request->file('file')->extension();
        $final_name = 'resume_' . time() . '.' . $ext;
        $request->file('file')->move(public_path('uploads/'), $final_name);

        $obj = new CandidateResume();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->name = $request->name;
        $obj->file = $final_name;
        $obj->save();

        return redirect()->route('candidate_resume')->with('success', 'Resume is added successfully.');
    }

    // Show form to edit resume
    public function resume_edit($id)
    {
        $resume_single = CandidateResume::where('id', $id)->first();
        return view('candidate.resume_edit', compact('resume_single'));
    }

    // Update resume record
    public function resume_update(Request $request, $id)
    {
        $obj = CandidateResume::where('id', $id)->first();
        $request->validate(['name' => 'required']);

        if ($request->hasFile('file')) {
            $request->validate(['file' => 'mimes:pdf,doc,docx']);
            unlink(public_path('uploads/' . $obj->file));

            $ext = $request->file('file')->extension();
            $final_name = 'resume_' . time() . '.' . $ext;
            $request->file('file')->move(public_path('uploads/'), $final_name);
            $obj->file = $final_name;
        }

        $obj->name = $request->name;
        $obj->update();

        return redirect()->route('candidate_resume')->with('success', 'Resume is updated successfully.');
    }

    // Delete resume record
    public function resume_delete($id)
    {
        $resume_single = CandidateResume::where('id', $id)->first();
        unlink(public_path('uploads/' . $resume_single->file));
        CandidateResume::where('id', $id)->delete();
        return redirect()->route('candidate_resume')->with('success', 'Resume is deleted successfully.');
    }

    // Add job to bookmarks
    public function bookmark_add($id)
    {
        $existing_bookmark_check = CandidateBookmark::where('candidate_id', Auth::guard('candidate')->user()->id)->where('job_id', $id)->count();
        if ($existing_bookmark_check > 0) {
            return redirect()->back()->with('error', 'This job is already added to the bookmark');
        }

        $obj = new CandidateBookmark();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->job_id = $id;
        $obj->save();

        return redirect()->back()->with('success', 'Job is added to bookmark section successfully.');
    }

    // View bookmarked jobs
    public function bookmark_view()
    {
        $bookmarked_jobs = CandidateBookmark::with('rJob', 'rCandidate')->where('candidate_id', Auth::guard('candidate')->user()->id)->get();
        return view('candidate.bookmark', compact('bookmarked_jobs'));
    }

    // Remove job from bookmarks
    public function bookmark_delete($id)
    {
        CandidateBookmark::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Bookmark item is deleted successfully.');
    }

    // Show form to apply for a job
    public function apply($id)
    {
        $existing_apply_check = CandidateApplication::where('candidate_id', Auth::guard('candidate')->user()->id)->where('job_id', $id)->count();
        if ($existing_apply_check > 0) {
            return redirect()->back()->with('error', 'You already have applied on this job!');
        }

        $job_single = Job::where('id', $id)->first();
        return view('candidate.apply', compact('job_single'));
    }

    // Submit application for a job
    public function apply_submit(Request $request, $id)
    {
        $request->validate(['cover_letter' => 'required']);
        $obj = new CandidateApplication();
        $obj->candidate_id = Auth::guard('candidate')->user()->id;
        $obj->job_id = $id;
        $obj->cover_letter = $request->cover_letter;
        $obj->status = 'Applied';
        $obj->save();

        $job_info = Job::with('rCompany')->where('id', $id)->first();
        $company_email = $job_info->rCompany->email;

        // Send email to company regarding application
        $applicants_list_url = route('company_applicants', $id);
        $subject = 'A person applied to a job';
        $message = 'Please check the application: <a href="' . $applicants_list_url . '">Click here to see applicants list for this job</a>';
        \Mail::to($company_email)->send(new WebsiteMail($subject, $message));

        return redirect()->route('job', $id)->with('success', 'Your application is sent successfully!');
    }

    // View candidate job applications
    public function applications()
    {
        $applied_jobs = CandidateApplication::with('rJob')
        ->where('candidate_id', Auth::guard('candidate')->user()->id)
        ->get();

    // Return the view for displaying the candidate's job applications
    return view('candidate.applications', compact('applied_jobs'));
}
}
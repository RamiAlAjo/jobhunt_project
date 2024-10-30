<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes from Laravel's Eloquent ORM
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Define the CandidateBookmark model which interacts with the candidate_bookmarks table
class CandidateBookmark extends Model
{
    // Use the HasFactory trait to enable factory support for testing and seeding
    use HasFactory;

    // Define a relationship to the Candidate model
    public function rCandidate()
    {
        // Establish a "belongsTo" relationship to the Candidate model.
        // Each CandidateBookmark belongs to one Candidate, based on the 'candidate_id' foreign key.
        // This represents a One-to-Many relationship:
        // One Candidate can have many CandidateBookmarks.
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    // Define a relationship to the Job model
    public function rJob()
    {
        // Establish a "belongsTo" relationship to the Job model.
        // Each CandidateBookmark belongs to one Job, based on the 'job_id' foreign key.
        // This also represents a One-to-Many relationship:
        // One Job can have many CandidateBookmarks.
        return $this->belongsTo(Job::class, 'job_id');
    }
}
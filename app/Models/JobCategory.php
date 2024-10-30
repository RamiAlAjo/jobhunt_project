<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes from Laravel's Eloquent ORM
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Define the JobCategory model for interacting with the job_categories table
class JobCategory extends Model
{
    // Use the HasFactory trait to enable factory support for testing and seeding
    use HasFactory;

    // Define a relationship to the Job model
    public function rJob()
    {
        // Establish a "hasMany" relationship with the Job model.
        // Each JobCategory can have many Job postings, so this is a One-to-Many relationship.
        // Example usage: Retrieve all jobs in a specific category.
        return $this->hasMany(Job::class);
    }
}
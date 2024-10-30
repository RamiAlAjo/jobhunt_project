<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes from Laravel's Eloquent ORM
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Define the Job model for interacting with the jobs table
class Job extends Model
{
    // Use the HasFactory trait to enable factory support for testing and seeding
    use HasFactory;

    // Define a relationship to the Company model
    public function rCompany()
    {
        // Establish a "belongsTo" relationship with the Company model.
        // Each Job belongs to one specific Company, identified by 'company_id'.
        // This represents a Many-to-One relationship:
        // Many jobs can belong to one company.
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Define a relationship to the JobCategory model
    public function rJobCategory()
    {
        // Establish a "belongsTo" relationship with the JobCategory model.
        // Each Job belongs to one specific JobCategory, identified by 'job_category_id'.
        // Many jobs can be assigned to the same category.
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    // Define a relationship to the JobLocation model
    public function rJobLocation()
    {
        // Establish a "belongsTo" relationship with the JobLocation model.
        // Each Job belongs to one specific JobLocation, identified by 'job_location_id'.
        // Multiple jobs can be posted at the same location.
        return $this->belongsTo(JobLocation::class, 'job_location_id');
    }

    // Define a relationship to the JobType model
    public function rJobType()
    {
        // Establish a "belongsTo" relationship with the JobType model.
        // Each Job has one specific JobType, identified by 'job_type_id' (e.g., full-time, part-time).
        // Many jobs can share the same type.
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    // Define a relationship to the JobExperience model
    public function rJobExperience()
    {
        // Establish a "belongsTo" relationship with the JobExperience model.
        // Each Job requires one specific JobExperience level, identified by 'job_experience_id'.
        // Multiple jobs can share the same experience level.
        return $this->belongsTo(JobExperience::class, 'job_experience_id');
    }

    // Define a relationship to the JobGender model
    public function rJobGender()
    {
        // Establish a "belongsTo" relationship with the JobGender model.
        // Each Job specifies one specific JobGender requirement, identified by 'job_gender_id'.
        // Many jobs may have the same gender requirement.
        return $this->belongsTo(JobGender::class, 'job_gender_id');
    }

    // Define a relationship to the JobSalaryRange model
    public function rJobSalaryRange()
    {
        // Establish a "belongsTo" relationship with the JobSalaryRange model.
        // Each Job has one specific JobSalaryRange, identified by 'job_salary_range_id'.
        // Multiple jobs can offer the same salary range.
        return $this->belongsTo(JobSalaryRange::class, 'job_salary_range_id');
    }
}
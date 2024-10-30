<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Define the Company model for interacting with the companies table
// Extending Authenticatable allows this model to support authentication
class Company extends Authenticatable
{
    // Use the HasFactory trait to enable factory support for testing and seeding
    use HasFactory;

    // Define a relationship to the Job model
    public function rJob()
    {
        // Establish a "hasMany" relationship with the Job model.
        // Each Company can post many Job listings, so this is a One-to-Many relationship.
        return $this->hasMany(Job::class);
    }

    // Define a relationship to the CompanyIndustry model
    public function rCompanyIndustry()
    {
        // Establish a "belongsTo" relationship with the CompanyIndustry model.
        // Each Company belongs to one specific CompanyIndustry, identified by 'company_industry_id'.
        // This represents a Many-to-One relationship:
        // Many Companies can belong to the same Industry.
        return $this->belongsTo(CompanyIndustry::class, 'company_industry_id');
    }

    // Define a relationship to the CompanyLocation model
    public function rCompanyLocation()
    {
        // Establish a "belongsTo" relationship with the CompanyLocation model.
        // Each Company is located in one specific CompanyLocation, identified by 'company_location_id'.
        // This represents a Many-to-One relationship:
        // Multiple Companies can be located in the same Location.
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }

    // Define a relationship to the CompanySize model
    public function rCompanySize()
    {
        // Establish a "belongsTo" relationship with the CompanySize model.
        // Each Company has one specific CompanySize, identified by 'company_size_id'.
        // This represents a Many-to-One relationship:
        // Many Companies can have the same CompanySize.
        return $this->belongsTo(CompanySize::class, 'company_size_id');
    }
}
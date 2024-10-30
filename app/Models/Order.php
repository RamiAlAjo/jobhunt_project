<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes from Laravel's Eloquent ORM
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Define the Order model for interacting with the orders table
class Order extends Model
{
    // Use the HasFactory trait to enable factory support for testing and seeding
    use HasFactory;

    // Define a relationship to the Company model
    public function rCompany()
    {
        // Establish a "belongsTo" relationship with the Company model.
        // Each Order belongs to one specific Company, identified by 'company_id'.
        // This is a Many-to-One relationship, as multiple orders can belong to the same company.
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Define a relationship to the Package model
    public function rPackage()
    {
        // Establish a "belongsTo" relationship with the Package model.
        // Each Order is linked to one specific Package, identified by 'package_id'.
        // This is a Many-to-One relationship, as multiple orders can be for the same package.
        return $this->belongsTo(Package::class, 'package_id');
    }
}
<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes for Laravel's Eloquent ORM functionality
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Define the WhyChooseItem model for interacting with the why_choose_items table
class WhyChooseItem extends Model
{
    // Use the HasFactory trait to enable factory support for testing and seeding
    use HasFactory;
}
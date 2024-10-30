<?php

// Define the namespace for the model to organize code and avoid naming conflicts
namespace App\Models;

// Import necessary classes for user authentication and features
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Define the User model for interacting with the users table and handling authentication
class User extends Authenticatable
{
    // Use HasApiTokens to support API tokens for authentication, 
    // HasFactory for testing and seeding, and Notifiable for sending notifications
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Only these attributes can be set during mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // User's name
        'email',       // User's email address
        'password',    // User's password (hashed for security)
    ];

    /**
     * The attributes that should be hidden for serialization.
     * These fields will be excluded from JSON and array outputs.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',         // Hide the password for security
        'remember_token',   // Hide the remember token used for session persistence
    ];

    /**
     * The attributes that should be cast to native types.
     * Casts allow Laravel to automatically convert these attributes to specified data types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Convert email_verified_at to a DateTime instance
    ];
}
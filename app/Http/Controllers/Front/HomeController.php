<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageHomeItem;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\Job;
use App\Models\WhyChooseItem;
use App\Models\Testimonial;
use App\Models\Post;

/**
 * Purpose: This controller handles the logic for displaying the homepage. 
 * It fetches and compiles various types of data including job categories, 
 * featured jobs, testimonials, and blog posts to create a dynamic and 
 * informative home page for users.
 */
class HomeController extends Controller
{
    /**
     * The index method is responsible for gathering data from various models 
     * and passing it to the home view. This data includes job categories, 
     * job locations, featured jobs, testimonials, and other sections on the 
     * homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Retrieve homepage-specific content such as banners and headings
        $home_page_data = PageHomeItem::where('id',1)->first();

        // Fetch job categories and include job counts for each, ordering by job count (descending)
        $job_categories = JobCategory::withCount('rJob')->orderBy('r_job_count','desc')->take(9)->get();

        // Fetch all job categories for a complete listing
        $all_job_categories = JobCategory::orderBy('name','asc')->get();

        // Fetch all job locations to be used in location-based search filters
        $all_job_locations = JobLocation::orderBy('name','asc')->get();

        // Retrieve the "Why Choose Us" section items, showcasing unique selling points
        $why_choose_items = WhyChooseItem::get();

        // Fetch all testimonials to display client or user reviews on the homepage
        $testimonials = Testimonial::get();

        // Fetch the latest 3 blog posts, ordered by newest first, for the news or blog section
        $posts = Post::orderBy('id','desc')->take(3)->get();

        // Retrieve featured jobs, including related models for detailed information
        $featured_jobs = Job::with([
            'rCompany', 
            'rJobCategory', 
            'rJobLocation', 
            'rJobType', 
            'rJobExperience', 
            'rJobGender', 
            'rJobSalaryRange'
        ])->orderBy('id','desc')->where('is_featured',1)->take(4)->get();

        // Pass all fetched data to the home view for rendering
        return view('front.home', compact(
            'home_page_data', 
            'job_categories', 
            'all_job_categories', 
            'all_job_locations', 
            'why_choose_items', 
            'testimonials', 
            'posts', 
            'featured_jobs'
        ));
    }
}
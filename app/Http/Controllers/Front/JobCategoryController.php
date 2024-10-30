<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\PageJobCategoryItem;

/**
 * Purpose: This controller handles the retrieval and display of job categories.
 * It fetches job categories and their job counts, and then passes this data to 
 * the job categories view for rendering. It also retrieves page-specific settings 
 * for customizing the job categories page layout and content.
 */
class JobCategoryController extends Controller
{
    /**
     * Displays the job categories page.
     * Retrieves all job categories along with the count of jobs in each category, 
     * and page-specific settings for the job categories page.
     *
     * @return \Illuminate\View\View
     */
    public function categories()
    {
        // Fetch settings and content specific to the job categories page, such as title and banner image
        $job_category_page_item = PageJobCategoryItem::where('id',1)->first();

        // Retrieve all job categories along with a count of jobs in each category, ordered by job count descending
        $job_categories = JobCategory::withCount('rJob')->orderBy('r_job_count','desc')->get();

        // Pass the job categories and page-specific settings to the view for rendering
        return view('front.job_categories', compact('job_categories', 'job_category_page_item'));
    }
}
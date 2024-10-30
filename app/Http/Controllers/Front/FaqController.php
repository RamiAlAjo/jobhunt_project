<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\PageFaqItem;

class FaqController extends Controller
{
    /**
 * The FaqController handles the logic for displaying the FAQ (Frequently Asked Questions) page.
 * 
 * Purpose:
 * - This controller is responsible for fetching and displaying a list of FAQs on the front end.
 * - It also retrieves any additional page-specific content such as headers, introductory text, 
 *   or other customizable elements to provide context or enhance the FAQ page.
 * - The FAQs and additional content are then passed to the view to be rendered for users to 
 *   easily find answers to common questions.
 */

    // Display the FAQ page with a list of FAQs and page-specific content
    public function index() 
    {
        // Step 1: Retrieve all FAQ items from the database
        // The Faq model is used to fetch all records, which contain questions and answers for the FAQ page
        $faqs = Faq::get();

        // Step 2: Retrieve additional content for the FAQ page
        // This data might include a header, introductory text, or other settings specific to the FAQ page
        $faq_page_item = PageFaqItem::where('id', 1)->first();

        // Step 3: Pass the retrieved data to the FAQ view for rendering
        // The data includes the list of FAQs and any additional page content needed for display
        return view('front.faq', compact('faqs', 'faq_page_item'));
    }
}
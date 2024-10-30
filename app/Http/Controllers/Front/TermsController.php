<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageTermItem;

/**
 * Purpose: This controller handles the display of the terms and conditions page.
 * It retrieves terms and conditions content from the database, allowing for 
 * dynamic updates and easy management of the page content.
 */
class TermsController extends Controller
{
    /**
     * Displays the terms and conditions page.
     * Retrieves the terms content from the database for rendering.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Retrieve terms and conditions content and settings from the database
        $term_page_item = PageTermItem::where('id', 1)->first();

        // Pass the terms and conditions content to the terms view for rendering
        return view('front.terms', compact('term_page_item'));
    }
}
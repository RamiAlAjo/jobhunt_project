<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagePrivacyItem;

/**
 * Purpose: This controller handles the display of the privacy policy page.
 * It retrieves privacy policy content from the database, enabling the
 * dynamic rendering of this content on the front-end.
 */
class PrivacyController extends Controller
{
    /**
     * Displays the privacy policy page.
     * Retrieves the privacy policy content from the database to be rendered on the page.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Retrieve the privacy policy content and settings from the database
        $privacy_page_item = PagePrivacyItem::where('id', 1)->first();

        // Pass the privacy policy content to the privacy view for rendering
        return view('front.privacy', compact('privacy_page_item'));
    }
}
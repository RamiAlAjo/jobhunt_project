<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PagePricingItem;

/**
 * Purpose: This controller handles the pricing page, displaying a list of 
 * available packages with their details. It also retrieves page-specific 
 * settings for customizing the layout and content of the pricing page.
 */
class PricingController extends Controller
{
    /**
     * Displays the pricing page with a list of available packages.
     * Retrieves package data and page settings to customize the layout.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Retrieve all available packages to be displayed on the pricing page
        $packages = Package::get();

        // Fetch pricing page settings, such as title, description, and banner image
        $pricing_page_item = PagePricingItem::where('id', 1)->first();

        // Pass the packages and page settings to the pricing view for rendering
        return view('front.pricing', compact('packages', 'pricing_page_item'));
    }
}
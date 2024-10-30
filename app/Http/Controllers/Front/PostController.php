<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PageBlogItem;

/**
 * Purpose: This controller manages blog post listing and detail pages. 
 * It fetches posts for the main blog page and displays individual post 
 * details when requested, along with updating view counts for each post.
 */
class PostController extends Controller
{
    /**
     * Displays the blog listing page with paginated posts.
     * Retrieves blog page settings for customizing the layout and content.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        // Retrieve all blog posts ordered by latest first, paginating to show 6 posts per page
        $posts = Post::orderBy('id', 'desc')->paginate(6);

        // Fetch blog page settings for things like page title and meta description
        $blog_page_item = PageBlogItem::where('id', 1)->first();

        // Pass the posts and page settings data to the blog listing view
        return view('front.blog', compact('posts', 'blog_page_item'));
    }

    /**
     * Displays the detail page for a single blog post.
     * Updates the view count for the post and passes the post data to the view.
     *
     * @param  string $slug
     * @return \Illuminate\View\View
     */
    public function detail($slug)
    {
        // Retrieve the blog post based on the slug, which is a unique identifier in the URL
        $post_single = Post::where('slug', $slug)->first();

        // Increment the total view count for the post and update the record
        $post_single->total_view = $post_single->total_view + 1;
        $post_single->update();

        // Pass the post data to the single post detail view
        return view('front.post', compact('post_single'));
    }
}
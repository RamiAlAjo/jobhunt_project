<?php

// Define the namespace for the controller within the admin section of the application
namespace App\Http\Controllers\Admin;

// Import necessary classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Post;

// Define the AdminPostController class to handle post-related actions in the admin panel
class AdminPostController extends Controller
{
    // Display a list of all posts
    public function index()
    {
        // Retrieve all posts from the Post model
        $posts = Post::get();
        
        // Return the 'admin.post' view, passing the list of posts
        return view('admin.post', compact('posts'));
    }

    // Show the form for creating a new post
    public function create()
    {
        // Return the 'admin.post_create' view to display the creation form
        return view('admin.post_create');
    }

    // Store a new post in the database
    public function store(Request $request)
    {
        // Validate that specific fields are required for the post
        $request->validate([
            'heading' => 'required',
            'slug' => 'required|alpha_dash|unique:posts',
            'short_description' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        // Create a new Post object and save the uploaded photo
        $obj = new Post();
        $ext = $request->file('photo')->extension();
        $final_name = 'post_' . time() . '.' . $ext;
        $request->file('photo')->move(public_path('uploads/'), $final_name);
        
        // Assign form data to the Post object
        $obj->photo = $final_name;
        $obj->heading = $request->heading;
        $obj->slug = $request->slug;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->total_view = 0;
        $obj->title = $request->title;
        $obj->meta_description = $request->meta_description;
        $obj->save();

        // Redirect to the post list with a success message
        return redirect()->route('admin_post')->with('success', 'Data is saved successfully.');
    }

    // Show the form for editing an existing post
    public function edit($id)
    {
        // Retrieve the specific post by ID
        $post_single = Post::where('id', $id)->first();
        
        // Return the 'admin.post_edit' view, passing the post data
        return view('admin.post_edit', compact('post_single'));
    }

    // Update an existing post in the database
    public function update(Request $request, $id)
    {
        // Retrieve the specific post by ID
        $obj = Post::where('id', $id)->first();

        // Validate required fields, with a unique check for the slug excluding the current post
        $request->validate([
            'heading' => 'required',
            'slug' => ['required', 'alpha_dash', Rule::unique('posts')->ignore($id)],
            'short_description' => 'required',
            'description' => 'required'
        ]);

        // If a new photo is uploaded, validate and replace the existing photo
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            unlink(public_path('uploads/' . $obj->photo));
            $ext = $request->file('photo')->extension();
            $final_name = 'post_' . time() . '.' . $ext;
            $request->file('photo')->move(public_path('uploads/'), $final_name);
            $obj->photo = $final_name;
        }

        // Update the post fields with new values and save to the database
        $obj->heading = $request->heading;
        $obj->slug = $request->slug;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->title = $request->title;
        $obj->meta_description = $request->meta_description;
        $obj->update();

        // Redirect to the post list with a success message
        return redirect()->route('admin_post')->with('success', 'Data is updated successfully.');
    }

    // Delete a post from the database
    public function delete($id)
    {
        // Retrieve the specific post by ID and delete its associated photo
        $post_single = Post::where('id', $id)->first();
        unlink(public_path('uploads/' . $post_single->photo));
        
        // Delete the post and redirect with a success message
        Post::where('id', $id)->delete();
        return redirect()->route('admin_post')->with('success', 'Data is deleted successfully.');
    }
}
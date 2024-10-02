<?php
namespace AppBlog\Blog\Http\Controllers;

use AppBlog\Blog\Models\Blog;
use Illuminate\Routing\Controller;

class BlogsController extends Controller
{
    public function index()
    {
        return Blog::all();
    }

    public function show($id)
    {
        return Blog::findOrFail($id);
    }
}
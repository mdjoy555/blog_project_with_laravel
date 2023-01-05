<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class SiteController extends Controller
{
    public function home()
    {
        $posts = $this->getPosts();

        return view('frontend.home',compact('posts'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function post_detail(Request $request,$id)
    {
        $post = Post::findOrFail($id);
        $categories = \DB::table('categories')->where('status',true)->get();

        return view('frontend.post_detail',compact('post','categories'));
    }

    private function getPosts()
    {
        return \DB::table('posts')
        ->where('posts.status',true)
        ->join('categories','categories.id','posts.category_id')
        ->select('posts.*','categories.category_name as category_name')
        ->orderBy('id')
        ->paginate(5);
    }
}

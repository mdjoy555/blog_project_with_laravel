<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = $this->getPosts();

        return view('posts.index',compact('posts'));
    }

    public function create()
    {
        cache()->remember('categories',60*60,function(){
            return \DB::table('categories')->where('status',true)->get();
        });
        
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:50000',
            'status' => 'required'
        ]);
        try
        {
            if($request->hasFile('image'))
            {
                $image = $request->file('image')->store('posts','public');
            }
            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'image' => isset($image)?$image:'dummy.jpg',
                'status' => $request->status
            ]);

            return to_route('posts.index')->with('message','Post Added Successfully');
        }
        catch(\Throwable $th)
        {
            throw $th;
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = \DB::table('categories')->where('status',true)->get();

        return view('posts.edit',compact('post','categories'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif|required|max:500000',
            'status' => 'required'
        ]);
        try
        {
            $post = Post::findOrFail($id);
            if($request->hasFile('image'))
            {
                $image = $request->file('image')->store('posts','public');
            }
            else
            {
                $image = $post->image;
            }
            $post->update([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'image' => isset($image)?$image:'dummy.jpg',
                'status' => $request->status
            ]);

            return to_route('posts.index')->with('message','Post Updated Successfully');
        }
        catch(\Throwable $th)
        {
            throw $th;
        }
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return to_route('posts.index')->with('message','Post Deleted Successfully');
    }

    private function getPosts()
    {
        return \DB::table('posts')
        ->where('posts.status',true)
        ->join('categories','categories.id','posts.category_id')
        ->select('posts.*','categories.category_name as category_name')
        ->orderBy('id')
        ->get();
    }
}

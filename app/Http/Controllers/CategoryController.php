<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index',compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|unique:categories|max:250',
            'status' => 'required'
        ]);

        try
        {
            $datas = Category::create($data);
            if($datas)
            {
                return to_route('categories.index')->with('message','Category Added Succesfully');
            }
        }
        catch(\Throwable $th)
        {
            throw $th;
        }
    }
    public function update(Request $request)
    {
        if($request->ajax())
        {
            $category = Category::find($request->id);
            if($category)
            {
                return response()->json($category,200);
            }
            else
            {
                $errors = "Don't be sneaky!";
                return response()->json(['errors'=>$errors],200);
            }
        }
        $data = $request->validate([
            'category_name' => 'required|string|unique:categories|max:250'.$request->category_id,
            'status' => 'required'
        ]);
        try
        {
            $datas = Category::findOrFail($request->category_id);

            if($datas)
            {
                $datas->update($data);

                return to_route('categories.index')->with('message','Category Updated Successfully');
            }
        }
        catch(\Throwable $th)
        {
            throw $th;
        }
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return to_route('categories.index')->with('message','Category Delete Successfully');
    }
}

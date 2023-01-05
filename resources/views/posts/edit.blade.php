@extends('layouts.master')
@section('header','Edit Post')
@section('Breadcrumb','Edit')
@section('content')

<div class="col-md-12">
    @include('message')
    <div class="box box-primary">
        <div class="box-header with-border">
            <a href="{{route('posts.index')}}" class="btn btn-primary pull-right">Back</a>
        </div>
        <form role="form" action="{{route('posts.update',$post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="post">Category</label>
                    <select class="form-control" name="category_id">
                        <option value="" selected>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"
                            {{$category->id==$post->category_id?'selected':''}}>
                            {{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="post">Title</label>
                    <input type="text" class="form-control" name="title" value="{{$post->title}}"
                    placeholder="Enter Post Title">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" rows="10" cols="40" name="description"
                    id="description">{{$post->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="post">Status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{$post->status==1?'selected':''}}>Active</option>
                        <option value="0" {{$post->status==0?'selected':''}}>Block</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
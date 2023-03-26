<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        
        return response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required!',
        ];

       $validater = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
       ],$messages);
        
       if($validater->fails()){
            return response()->json(['msg'=> $validater->errors()], 200);
       }else{
            $post = Post::create([
                'Title' => $request->title,
                'Description' => $request->description
            ]);
            return response()->json([$post, 'msg'=>'Data Create Successfully'], 200);
       }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->update([
            'Title' => $request->title,
            'Description' => $request->description,
        ]);

        return response()->json(['msg'=>'update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['msg'=>'Delete successfully'], 200);
    }
}

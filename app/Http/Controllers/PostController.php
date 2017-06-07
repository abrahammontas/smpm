<?php

namespace App\Http\Controllers;

use App\ImagesPost;
use Illuminate\Http\Request;
use App\Post;
use App\Account;
use App\Http\Requests;
use Session;
use App\Http\Requests\PostRules;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('posts.List', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all();

        return view('posts.Add', ['accounts' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRules $request)
    {
        $post = Post::create($request->all());

        if(isset($post->id)){
            if($request->image) {
                $hash = md5(microtime());
                Storage::put('/posts/'.$hash.$request->image->extension(), file_get_contents($request->file('image')));

                ImagesPost::create([
                    'post_id' => $post->id,
                    'image' => $hash.$request->image->extension()
                ]);
            }

            $message = "The post '".$request->input('name')."' has been created successfully.";
            $class = "alert alert-success";
        }
        else{
            $message = "Error! please try again.";
            $class = "alert alert-danger";
        }

        return redirect('post')->with('message', $message)
            ->with('class', $class);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.Edit', ['post' => Post::find($id), 'accounts' => Account::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRules $request, $id)
    {
        $post = Post::where('id', '=', $id)->update($request->all());

        if(isset($post)){
            $message = "The post '".$request->input('name')."' has been edited successfully.";
            $class   = "alert alert-success";
        }
        else{
            $message = "Error! please try again.";
            $class = "alert alert-danger";
        }

        return redirect('post')->with('message', $message)
            ->with('class', $class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        if(isset($post)){
            $message = "The post '".$post->name."' has been deleted successfully";
            $class = "alert alert-success";
        }
        else{
            $message = "Error! Please try again";
            $class = "alert alert-danger";
        }

        return redirect('post')->with('message', $message)
            ->with('class', $class);
    }
}

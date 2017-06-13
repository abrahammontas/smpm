<?php

namespace App\Http\Controllers;

use App\ImagesPost;
use Illuminate\Http\Request;
use App\Post;
use App\Account;
use App\Http\Requests;
use Session;
use Storage;
use Auth;
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
        $accounts = Account::where('user_id', '=', Auth::id())->select('id')->get()->toArray();

        $posts = Post::whereIn('account_id', $accounts)->get();

        return view('posts.List', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::where('user_id', '=', Auth::id())->get();

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
                Storage::disk('public')->put('/posts/'.$hash.'.'.$request->image->extension(), file_get_contents($request->file('image')));

                ImagesPost::create([
                    'post_id' => $post->id,
                    'image' => $hash.'.'.$request->image->extension()
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
        return view('posts.Show', ['post' => Post::find($id)]);
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
        $post = Post::where('id', '=', $id)->update([
                'text' => $request->input('text'),
                'post_time' => $request->input('post_time'),
                'account_id' => $request->input('account_id'),
            ]);

        if($request->image) {
            $post = Post::find($post);
            if(isset($post->images->first()->image)) {
                Storage::disk('public')->remove('/posts/'.$post->images->first()->image);
                ImagesPost::where('image', '=', $post->images->first()->image)->delete();
            }
            
            $hash = md5(microtime());
            Storage::disk('public')->put('/posts/'.$hash.'.'.$request->image->extension(), file_get_contents($request->file('image')));

            ImagesPost::create([
                'post_id' => $post->id,
                'image' => $hash.'.'.$request->image->extension()
            ]);
        }

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

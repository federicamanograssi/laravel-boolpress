<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =[
            'posts'=> Post::all()
        ];
        return view('admin.posts.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:255',
            'content'=>'required'
        ]);

        $form_data=$request->all();
        $new_post = new Post();

        $new_post->fill($form_data);

        //genero slug
        $slug=Str::slug($new_post->title);
        $old_post= Post::where('slug',$slug)->first();
        $slug_counter=1;
        $base_slug=$slug;

        while($old_post){
            $slug=$base_slug.'-'. $slug_counter;
            $slug_counter++;
            $old_post= Post::where('slug',$slug)->first();
        }
        $new_post->slug=$slug;

        $new_post->user_id= Auth::id();
        $new_post->save();
        return redirect()->route('posts.index');

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
    public function edit(Post $post)
    {
        if(!$post){
            abort(404);
        };

        $data = [
            'post'=>$post
        ];

        return view('admin.posts.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required|max:255',
            'content'=>'required'
        ]);

        $form_data=$request->all();

        // verifico se titolo diverso da vecchio x rifare slug

        if($form_data['title'] != $post->title){
            $slug=Str::slug($form_data['title']);
            $base_slug=$slug;
            $old_post=Post::where('slug',$slug)->first();
            $slug_counter=1;

            while($old_post){
                $slug= $base_slug.'-'.$slug_counter;
                $slug_counter++;
                $old_post=Post::where('slug',$slug)->first();
            }
            $form_data['slug']=$slug;
        }
        
        $post->update($form_data);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}

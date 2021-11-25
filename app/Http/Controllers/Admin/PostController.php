<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $categories=Category::pluck('name','id'); //array de nombres
        $tags=Tag::all();
        return view('admin.posts.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        
        //creamos un post
        $post=Post::create($request->all());
        //guardamos imagen a la tabla y carpeta posts
        if($request->file('file')){
            $url = Storage::put('public/posts',$request->file('file'));
            
            $post->image()->create([
                'url' => $url
            ]);
        }


        //guardamos en la tabla muchos a muchos Posts_Tag
        if($request->tags){
            $post->tags()->attach($request->tags);
        }
        return redirect()->route('admin.posts.edit',$post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        $this->authorize('author',$post);
        $categories=Category::pluck('name','id'); //array de nombres
        $tags=Tag::all();
        return view('admin.posts.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //
        $this->authorize('author',$post);
        $post->update($request->all());
        if($request->file('file')){
            $url = Storage::put('public/posts',$request->file('file'));
            
            if($post->image){
                Storage::delete($post->image->url);
                $post->image()->update([
                    'url' => $url
                ]);
                
            }else{
                $post->image()->create([
                    'url' => $url
                ]);
            }
            
        }

         //guardamos en la tabla muchos a muchos Posts_Tag
         if($request->tags){
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.edit',$post)->with('info','El post se actualizo con exito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $this->authorize('author',$post);
        $post->delete();
        return redirect()->route('admin.posts.index',$post)->with('info','El post se elimino con exito');
    }
}

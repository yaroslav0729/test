<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostGroup;
use App\Models\Widget;
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
        $posts = Post::paginate(10);

        return view('admin.post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = PostGroup::all();
        $widgets = Widget::WIDGET_LABELS;
        return view('admin.post.create_edit', [
            'groups' => $groups,
            'widgets' => $widgets
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create($request->all());

        $gIds = $request->input('groups');
        $post->groups()->attach($gIds);

        $post->parseWidgets($request->input('widgets'));

        return redirect()->route('admin.post.index')->with('status', 'post created!');
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
        $post = Post::findOrFail($id);
        $groups = PostGroup::all();
        $widgets = Widget::WIDGET_LABELS;

        return view('admin.post.create_edit', [
            'post' => $post, 
            'groups' => $groups,
            'widgets' => $widgets,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        $gIds = $request->input('groups');
        $post->groups()->detach();
        $post->groups()->attach($gIds);

        $post->parseWidgets($request->input('widgets'));

        return redirect()->route('admin.post.index')->with('status', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.post.index')->with('status', 'Post deleted!');
    }

    public function renderWidget($id)
    {

    }
}

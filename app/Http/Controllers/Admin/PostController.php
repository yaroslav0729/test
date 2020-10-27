<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostGroup;
use App\Models\Widget;
use App\Models\WidgetParameters;
use App\Http\Requests\PostRequest;
use App\Http\Requests\Admin\WidgetAddRequest;
use App\Models\PostItem;

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
        
        return view('admin.post.create_edit', [
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
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

        return view('admin.post.create_edit', [
            'post' => $post, 
            'groups' => $groups,
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

        if ($post->slug !== $request->input('slug')) {
            $validatedData = $request->validate([
                'slug' => 'required|unique:posts'
            ]);
        }

        $post->update($request->all());

        $gIds = $request->input('groups');
        $post->groups()->detach();
        $post->groups()->attach($gIds);

        //$post->parseWidgets($request->input('widgets'));

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

    public function getWidgetModal()
    {
        $modalView = view('admin.modals.add_widget')->render();

        return response()->json([
            'html' => $modalView,
            'status' => 'success',
        ]); 
    }

    public function addWidget(WidgetAddRequest $request)
    {
        $widgetId = (int)$request->input('widget_id');
        $widget = PostItem::where('widget_id', $widgetId)->first();

        if (!$widget) {
            abort(404);
        }

        $widget = new PostItem(['widget_id' => $widgetId]);
        $widgetHtml = $widget->renderWidhElements()->render();

        return response()->json([
            'content' => $widgetHtml
        ], 200); 
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContainer;
use App\Models\PostGroup;
use App\Models\Widget;
use App\Models\WidgetParameters;
use App\Http\Requests\PostRequest;
use App\Http\Requests\Admin\WidgetAddRequest;
use App\Models\PostItem;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postContainers = PostContainer::paginate(10);

        return view('admin.post.index', ['postContainers' => $postContainers]);
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
        $validator = $this->_validateSlug($request);

        if (count($validator->errors())) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $postContainer = PostContainer::create();
        $data = $request->all();
        $data['post_container_id'] = $postContainer->id;
        $post = Post::create($data);
        $post->actual = true;
        $post->author()->associate(auth()->user());
        $post->save();
        
        $gIds = $request->input('groups');
        $post->groups()->attach($gIds);

        $post->parseWidgets($request);

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
        $post = Post::where('id', $id)->firstOrFail();
        $groups = PostGroup::all();

        return view('admin.post.history_post', [
            'post' => $post,
            'groups' => $groups,
        ]);
    }

    public function restore($id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $postContainer = PostContainer::where('id', $post->post_container_id)->firstOrFail();
        $oldActualPost = $postContainer->actual_post;
        $oldActualPost->actual = false;
        $oldActualPost->save();
        $post->actual = true;
        $post->save();

        return redirect()->route('admin.post.index')->with('status', 'Post restored!');

    }

    public function history($id)
    {
        $postContainer = PostContainer::where('id', $id)->firstOrFail();
        $posts = $postContainer->posts()->orderBy('id', 'desc')->get();

        return view('admin.post.history_index', ['posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postContainer = PostContainer::findOrFail($id);
        $groups = PostGroup::all();

        return view('admin.post.create_edit', [
            'postContainer' => $postContainer, 
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
        $validator = $this->_validateSlug($request, $id);

        if (count($validator->errors())) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $postContainer = PostContainer::findOrFail($id);
        $oldPost = $postContainer->actual_post;

        if (isset($oldPost)) {
            $oldPost->actual = false;
            $oldPost->save();   
        }
        $data = $request->all();
        $data['post_container_id'] = $oldPost->post_container_id;
        $data['author_id'] = $oldPost->author_id;

        $post = Post::create($data);
        $post->container()->associate($postContainer);
        $post->actual = true;
        $post->save();

        $gIds = $request->input('groups');
        $post->groups()->attach($gIds);

        $post->parseWidgets($request);

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
        $postContainer = PostContainer::findOrFail($id);
        $postContainer->delete();

        return redirect()->route('admin.post.index')->with('status', 'Post deleted!');
    }

    public function saveStatus(Request $request, $id)
    {
        $postContainer = PostContainer::findOrFail($id);
        $postContainer->status = $request->status;
        $postContainer->save();

        return redirect()->route('admin.post.index')->with('status', 'Post status changed successfully!');
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

        $widget = new PostItem(['widget_id' => $widgetId]);
        $widgetHtml = $widget->renderWithElements()->render();

        return response()->json([
            'content' => $widgetHtml
        ], 200); 
    }

    protected function _validateSlug($request, $id = null)
    {
        $validator = Validator::make($request->all(), []);
        $slug = $request->input('slug');
        $posts = Post::where('slug', $slug)
                        ->where('actual', true);

        if (isset($id)) {
            $posts = $posts->where('post_container_id', '<>', $id);
        }
        $posts = $posts->get();

        if (count($posts)) {
            $validator->errors()->add('slug', 'The slug must be unique to publish');
        }

        return $validator;
    }
}

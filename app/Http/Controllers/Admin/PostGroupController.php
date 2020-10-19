<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostGroup;

class PostGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pGroups = PostGroup::paginate(10);

        return view('admin.post_group.index', ['pGroups' => $pGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post_group.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pGroup = PostGroup::create($request->all());

        return redirect()->route('admin.post_group.index')->with('status', 'post group created!');
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
        $pGroup = PostGroup::findOrFail($id);

        return view('admin.post_group.create_edit', ['pGroup' => $pGroup]);
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
        $pGroup = PostGroup::findOrFail($id);
        $pGroup->update($request->all());

        return redirect()->route('admin.post_group.index')->with('status', 'Post group updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pGroup = PostGroup::findOrFail($id);
        $pGroup->delete();

        return redirect()->route('admin.post_group.index')->with('status', 'Post group deleted!');
    }
}

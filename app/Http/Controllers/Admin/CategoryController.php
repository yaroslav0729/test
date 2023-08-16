<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CreateEditCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $pGroups = Category::paginate(10);

        return view('admin.category.index', ['pGroups' => $pGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEditCategoryRequest $request)
    {
        $pGroup = Category::create($request->all());

        return redirect()->route('admin.category.index')->with('status', 'Category created!');
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
        $pGroup = Category::findOrFail($id);

        return view('admin.category.create_edit', ['pGroup' => $pGroup]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateEditCategoryRequest $request, $id)
    {
        $pGroup = Category::findOrFail($id);
        $pGroup->update($request->all());

        return redirect()->route('admin.category.index')->with('status', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pGroup = Category::findOrFail($id);
        $pGroup->delete();

        return redirect()->route('admin.category.index')->with('status', 'Category deleted!');
    }
}

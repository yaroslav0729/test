<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function callAction($method, $parameters)
    {
        if (isset($parameters['menuSlug']) && !in_array($parameters['menuSlug'], MenuItem::ALL_SLUG_MENU, true)) {
            abort(404);
        }
        return parent::callAction($method, $parameters);
    }

    public function index(string $menuSlug)
    {
        $menuItemsQuery = MenuItem::getMenuItems($menuSlug);
        $menuDestination = MenuItem::getMenuDestination($menuSlug);

        if (request('submenu')) {
            $menuItems = $menuItemsQuery->whereParentId(request('submenu'))->get();
        } else {
            $menuItems = $menuItemsQuery->whereNull('parent_id')->get();
        }

/*       $data = MenuItem::getMenu(MenuItem::HEADER_MENU);

        $firstMenu  = $data[2];
        dump($firstMenu);
        dump($firstMenu->subMenus()->get());

        $f = MenuItem::arrayMaxDepthChild($firstMenu->subMenus()->get());
        dump($f);*/



        return view('admin.menu_items.index', compact('menuItems', 'menuDestination', 'menuSlug'));
    }


    public function create(Request $request, string $menuSlug)
    {
        $menuDestination = MenuItem::getMenuDestination($menuSlug);
        $parentId = $request->input('parent_id');

        return view('admin.menu_items.create_edit', compact('menuDestination', 'parentId', 'menuSlug'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $menuSlug
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $menuSlug, int $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        return view('admin.menu_items.create_edit', ['menuSlug' => $menuSlug, 'menuItem' => $menuItem]);
    }

    public function store(MenuItemRequest $request)
    {
        $slugMenu = $request->input('slug');
        $data = $request->all();

        $parameters = ['menuSlug' => $slugMenu];
        if ($data['parent_id']) {
            $parameters['submenu'] = $data['parent_id'];
        }

        $menuItem = MenuItem::create($data);
        $menuItem->save();

        return redirect()->route('admin.menu_items.index', $parameters)->with('status', 'Item menu created successfully!');
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param MenuItemRequest $request
     * @param string $slugMenu
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MenuItemRequest $request, string $slugMenu, int $id)
    {
        $parameters = ['menuSlug' => $slugMenu];
        if ($request['parent_id']) {
            $parameters['submenu'] = $request['parent_id'];
        }

        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($request->all());

        return redirect()->route('admin.menu_items.index', $parameters)->with('status', 'Item Menu updated!');
    }

    /**
     *
     * @param string $slug
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $slug, int $id)
    {
        $page = MenuItem::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.menu_items.index', ['menuSlug' => $slug])->with('status', 'Item menu deleted successfully!');
    }

}

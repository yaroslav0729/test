<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Models\MenuItem;
use App\Services\Menu;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    private $menuService;

    public function __construct(Menu $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        return view('admin.menu_items.index', [
            'menuTypes' => array_combine(MenuItem::ALL_SLUG_MENU, MenuItem::ALL_TYPES_MENU)
        ]);
    }

    public function show(string $menuSlug)
    {
        $menuDestination = $this->menuService->getMenuDestination($menuSlug);

        $menuItems = $this->menuService->getMenuItemsByDestination($menuDestination);
        $menuName = $this->menuService->getMenuName($menuDestination);
        $createLink = route('admin.menu_items.create', ['menuSlug' => $menuSlug]);

        return view('admin.menu_items.show', compact('menuItems', 'menuName', 'createLink'));
    }

    public function showSubmenu(MenuItem $parent)
    {
        $menuItems = $this->menuService->getMenuItemsByParent($parent->id);
        $menuName = $this->menuService->getMenuName($parent->destination);
        $createLink = route('admin.menu_items.create_submenu', ['parent' => $parent->id]);

        return view('admin.menu_items.show', compact('menuItems', 'menuName', 'parent', 'createLink'));
    }

    public function create(Request $request, string $menuSlug)
    {
        $menuDestination = $this->menuService->getMenuDestination($menuSlug);
        $isMenuAdditional = $this->menuService->isMenuAdditional($menuDestination);
        $menuName = $this->menuService->getMenuName($menuDestination);

        $isGroup = $isMenuAdditional ? 0 : old('is_group', 0);

        $groupCheckboxChecked = $isGroup ? 'checked' : null;
        $groupCheckboxDisabled = null;
        $linkInputDisabled = $isGroup ? 'disabled' : null;

        $text = old('text');
        $link = is_null($linkInputDisabled) ? old('link') : null;

        $storeLink = route('admin.menu_items.store', ['menuSlug' => $menuSlug]);
        $textValues = $this->menuService->getPredefinedTextValuesList($menuDestination);

        return view('admin.menu_items.create', compact(
            'menuDestination', 
            'menuSlug', 
            'isMenuAdditional', 
            'menuName',
            'text',
            'link',
            'linkInputDisabled',
            'groupCheckboxChecked',
            'groupCheckboxDisabled',
            'storeLink',
            'textValues'
        ));
    }

    public function createSubmenu(MenuItem $parent)
    {
        $isMenuAdditional = $this->menuService->isMenuAdditional($parent->destination);
        $menuName = $this->menuService->getMenuName($parent->destination);

        $isGroup = $isMenuAdditional ? 0 : old('is_group', 0);

        $groupCheckboxChecked = $isGroup ? 'checked' : null;
        $groupCheckboxDisabled = null;
        $linkInputDisabled = $isGroup ? 'disabled' : null;

        $text = old('text');
        $link = is_null($linkInputDisabled) ? old('link') : null;

        $storeLink = route('admin.menu_items.store_submenu', ['parent' => $parent->id]);
        $textValues = $this->menuService->getPredefinedTextValuesList($parent->destination);

        return view('admin.menu_items.create', compact(
            'isMenuAdditional', 
            'menuName',
            'text',
            'link',
            'linkInputDisabled',
            'groupCheckboxChecked',
            'groupCheckboxDisabled',
            'storeLink',
            'textValues'
        ));
    }

    public function edit(MenuItem $menuItem)
    {
        $groupCheckboxChecked = $menuItem->is_group ? 'checked' : null;
        $groupCheckboxDisabled = 'disabled';
        $linkInputDisabled = $menuItem->is_group ? 'disabled' : null;

        $isMenuAdditional = $this->menuService->isMenuAdditional($menuItem->destination);
        $menuName = $this->menuService->getMenuName($menuItem->destination);
        $textValues = $this->menuService->getPredefinedTextValuesList($menuItem->destination);

        $text = old('text', $menuItem->text);
        $link = is_null($linkInputDisabled) ? old('link', $menuItem->link) : null;
        $menuId = $menuItem->id;

        return view('admin.menu_items.edit', compact(
            'groupCheckboxChecked',
            'groupCheckboxDisabled',
            'linkInputDisabled',
            'isMenuAdditional',
            'menuName',
            'textValues',
            'text',
            'link',
            'menuId'
        ));
    }

    public function storeSubmenu(MenuItemRequest $request, MenuItem $parent)
    {
        $data = $request->validated();

        $parent->subMenus()->create($data + [
            'destination' => $parent->destination
        ]);

        return redirect()->route('admin.menu_items.show_submenu', $parent)->with('status', 'Item menu created successfully!');
    }

    public function store(MenuItemRequest $request, string $menuSlug)
    {
        $data = $request->validated();

        $menuDestination = $this->menuService->getMenuDestination($menuSlug);

        MenuItem::create($data + [
            'destination' => $menuDestination
        ]);

        return redirect()->route('admin.menu_items.show', $menuSlug)->with('status', 'Item menu created successfully!');
    }

    public function update(MenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());

        if ($menuItem->parent_id) {
            $redirectRoute = route('admin.menu_items.show_submenu', ['parent' => $menuItem->parent_id ]);
        } else {
            $redirectRoute = route('admin.menu_items.show', ['menuSlug' => $this->menuService->getSlug($menuItem->destination) ]);
        }

        return redirect($redirectRoute)->with('status', 'Item Menu updated!');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        if ($menuItem->parent_id) {
            $redirectRoute = route('admin.menu_items.show_submenu', ['parent' => $menuItem->parent_id ]);
        } else {
            $redirectRoute = route('admin.menu_items.show', ['menuSlug' => $this->menuService->getSlug($menuItem->destination) ]);
        }

        return redirect($redirectRoute)->with('status', 'Item menu deleted successfully!');
    }

    public function moveUp(MenuItem $menuItem)
    {
        $menuItem->moveOrderUp();

        return back()->with('status', 'Item menu moved up successfully!');
    }

    public function moveDown(MenuItem $menuItem)
    {
        $menuItem->moveOrderDown();
        
        return back()->with('status', 'Item menu moved down successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Category;
use App\Http\Requests\PageCreateEditRequest;
use App\Http\Requests\Admin\WidgetAddRequest;
use App\Models\PostItem;
use Illuminate\Support\Facades\Validator;
Use \Carbon\Carbon;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('filter') === 'events') {
            $pages = Page::getAllEvents()->paginate(20);
        } else {
            $pages = Page::paginate(20);
        }

        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.pages.create_edit', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageCreateEditRequest $request)
    {
        $validator = $this->_validateSlug($request);

        if (count($validator->errors())) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $templateValidator = $this->_validateTemplate($request);

        $page = Page::create();
        $data = $request->all();
        $data['page_id'] = $page->id;
        if (isset($data['parameters']['amount'])) {
            $data['parameters']['amount'] = $this->replaceKeys($data['parameters']['amount']);
        }
        $pageInstance = PageInstance::create($data);
        $pageInstance->actual = true;
        $pageInstance->author()->associate(auth()->user());

        $cIds = $request->input('categories');
        $pageInstance->categories()->attach($cIds);

        $pageInstance->save();

        if ((int)$pageInstance->template === Template::EVENT_PAGE) {
            $event = Event::updateOrCreate(['page_id'=> $page->id], $data);
        }

        return redirect()->route('admin.pages.index')->with('status', 'Page created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageInstance = PageInstance::where('id', $id)->firstOrFail();

        return view('admin.pages.history_page', [
            'pageInstance' => $pageInstance,
        ]);
    }

    public function preview($id)
    {
        $pageInstance = PageInstance::where('id', $id)->firstOrFail();

        return view('page', compact('pageInstance'));
    }

    public function restore($id)
    {
        $pageInstance = PageInstance::where('id', $id)->firstOrFail();
        $page = Page::where('id', $pageInstance->page_id)->firstOrFail();
        $oldActualPage = $page->actual_page_instance;
        $oldActualPage->actual = false;
        $oldActualPage->save();
        $pageInstance->actual = true;
        $pageInstance->save();

        return redirect()->route('admin.pages.index')->with('status', 'Page restored successfully!');

    }

    public function history($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        $pageInstances = $page->pageInstances()->orderBy('id', 'desc')->get();

        return view('admin.pages.history_index', ['pageInstances' => $pageInstances]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $categories = Category::all();

        return view('admin.pages.create_edit', [
            'page' => $page,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function replaceKeys($amount) {

        $amountNew = [];

        foreach ($amount as $price) {
            $amountNew[] = $price;
        }

        return $amountNew;
    }

    public function update(PageCreateEditRequest $request, $id)
    {
        $validator = $this->_validateSlug($request, $id);

        if (count($validator->errors())) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $templateValidator = $this->_validateTemplate($request);

        $page = Page::findOrFail($id);
        $oldPage = $page->actual_page_instance;

        if (isset($oldPage)) {
            $oldPage->actual = false;
            $oldPage->save();
        }
        $data = $request->all();
        $data['page_id'] = $oldPage->page_id;
        $data['author_id'] = $oldPage->author_id;
        if (isset($data['parameters']['amount'])) {
            $data['parameters']['amount'] = $this->replaceKeys($data['parameters']['amount']);
        }

        $pageInstance = PageInstance::create($data);
        $pageInstance->page()->associate($page);
        $pageInstance->actual = true;
        $pageInstance->save();

        $cIds = $request->input('categories');
        $pageInstance->categories()->attach($cIds);

        $page->removeOldHistory();

        if ((int)$pageInstance->template === Template::EVENT_PAGE) {
            $event = Event::updateOrCreate(['page_id'=> $page->id], $data);
        }

        return redirect()->route('admin.pages.index')->with('status', 'Page updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')->with('status', 'Page deleted successfully!');
    }

    public function saveStatus(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->status = $request->status;

        if ((int)$page->status === Page::PAGE_STATUS_PUBLICHED) {
            $page->published_at = Carbon::now();
        }

        $page->save();

        return redirect()->route('admin.pages.index')->with('status', 'Page status changed successfully!');
    }

    public function getTemplateForm($templateId, Request $request)
    {
        $template = view('templates.form.' . $templateId, ['parameters' => []])->render();

        $currentId = $request->input('current_page_instance_id');
        if ($currentId) {
            $pageInstance = PageInstance::where('id', $currentId)->firstOrFail();

            if ((int)$templateId === $pageInstance->template) {
                $template = $pageInstance->renderTemplateParametersForm()->render();
            }
        }

        return response()->json([
            'html' => $template,
            'status' => 'success',
        ]);
    }

    protected function _validateSlug($request, $id = null)
    {
        $validator = Validator::make($request->all(), []);
        $slug = $request->input('slug');
        $pageInstances = PageInstance::where('slug', $slug)
                            ->where('actual', true);

        if (isset($id)) {
            $pageInstances = $pageInstances->where('page_id', '<>', $id);
        }
        $pageInstances = $pageInstances->get();

        if (count($pageInstances)) {
            $validator->errors()->add('slug', 'The slug must be unique to publish');
        }

        return $validator;
    }

    protected function _validateTemplate(Request $request)
    {
        $validationRules = \App\Models\Template::getValidationRules((int)$request->template);
        $validatedData = $request->validate($validationRules);
    }
}

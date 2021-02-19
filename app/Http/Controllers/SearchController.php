<?php


namespace App\Http\Controllers;


use App\Models\Page;
use App\Models\PageInstance;
use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;


class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $search = true;

        $pages = Page::whereHas('pageInstances');

        if (!empty($keyword)) {
            $pages = $pages->whereHas('pageInstances', function (Builder $query) use ($keyword) {
                $query->where('name', 'like',  '%' . $keyword . '%');
                $query->orWhere('preview_text', 'like',  '%' . $keyword . '%');
            });
        }
        $pages = $pages->get();

        $configTemplate = Template::getConfigureTemplate(88);

        return view('search.index', compact('configTemplate', 'pages', 'search'));
    }

}

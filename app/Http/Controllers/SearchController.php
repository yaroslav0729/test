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

        $pages = Page::whereHas('pageInstances')->published();
        if (!empty($keyword)) {
            $pages = $pages->whereHas('pageInstances', function (Builder $query) use ($keyword) {
                $query->where('name', 'like',  '%' . $keyword . '%');
                $query->orWhere('preview_text', 'like',  '%' . $keyword . '%');
            });
        }

        $countPage = $pages->count();
        $pages = $pages->paginate(10);
        $configTemplate = Template::getConfigureTemplate(88);

        return view('search.index', compact('configTemplate', 'pages', 'keyword', 'countPage'));
    }

}

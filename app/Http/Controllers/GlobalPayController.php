<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GlobalPayController extends Controller
{
    public function result(Request $request)
    {
        Log::info('Global pay request: ' . $request);

        $pageInstance = PageInstance::where('template', Template::THANK_YOU_DONATE_PAGE)->actual()->first();

        if (!$pageInstance) {
            die('Page with template "' . Template::getLabel(Template::THANK_YOU_DONATE_PAGE) . '" is not found.');
        }

        $html = $pageInstance->renderTemplate()->render();
        $html = \App\Models\Widget::replaceMonikers($html);
        $configTemplate = Template::getConfigureTemplate($pageInstance->template);

        return view('page', compact('html', 'configTemplate'));
    }

    public function statusUpdate(Request $request)
    {
        Log::info('Global pay status update: ' . $request);

        return response()->json([
            'message' => 'Success Global pay status update page',
            'success' => true,
            'request' => $request->all(),
        ]);
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\PageInstance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePages extends Command
{
    protected $wpConnection;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->wpConnection = DB::connection('wp');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start updating pages...');

        $pages = PageInstance::where(['template' => 6])->get();
        foreach ($pages as $page) {
            if (is_string($page->parameters)) {
                $page->update(['parameters' => json_decode($page->parameters)]);
                $page->save();
            }
        }
        // $parsedPages = $this->wpConnection->table('pages')->get();
        // $parsedPagesInstances = $this->wpConnection->table('page_instances')->get();

        // $updatePages = [];
        // $pagesData = [];

        // for ($i = 0; $i < count($parsedPages); $i++) {
        //     $this->info($parsedPages[$i]->wp_id . ': Trying to find page ' . $parsedPages[$i]->wp_id);
        //     $page = Page::where(['wp_id' => $parsedPages[$i]->wp_id])->first();

        //     if (!$page) {
        //         $data = json_decode(json_encode($parsedPages[$i]), true);
        //         $oldId = $data['id'];
        //         unset($data['id']);
        //         $page = Page::create($data);
        //         $updatePages[] = $page;
        //         $pagesData[$oldId] = [
        //             $oldId => [
        //                 'id' => $page->id,
        //                 'wp_id' => $page->wp_id,
        //             ]
        //         ];
        //         $this->info('Created page with wp_id: ' . $page->wp_id);
        //     } else {
        //         $this->info('Page founded: ' . $page->wp_id);
        //     }
        // }
        // // dd(count($parsedPages), count($pagesForUpdate), count($parsedPagesInstances), count($pageInstancesForUpdate));

        // foreach ($parsedPagesInstances as $parsedPage) {
        //     $pageForUpdate = PageInstance::where(['slug' => $parsedPage->slug, 'actual' => true])->first();
        //     $pageInstanceData = json_decode(json_encode($parsedPage), true);
        //     unset($pageInstanceData['id']);
        //     unset($pageInstanceData['page_id']);
        //     if (!$pageForUpdate) {
        //         $pageInstanceData['page_id'] = Page::where(['id' => $pagesData])->first()->id;
        //         $pagesInstanceData['actual'] = 1;
        //         $pagesInstanceData['parameters'] = json_decode($pageInstanceData['parameters']);
        //         $pageForUpdate = PageInstance::create($pageInstanceData);
        //         $this->info('Page Instace Created: ' . $pageForUpdate->id);
        //     } else {
        //         $pagesInstanceData['parameters'] = json_decode($pageInstanceData['parameters']);
        //         $pageForUpdate->update($pageInstanceData);
        //         $this->info('Page Instancec Updated: ' . $pageForUpdate->id);
        //     }
        // }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;

class IndexPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=IndexPageSeeder
     * 
     * @return void
     */
    public function run()
    {
        $indexPage = Page::index()->get();

        if (!count($indexPage)) {

            $page = Page::create([
                'type' => Page::TYPE_INDEX_PAGE,
                'status' => Page::PAGE_STATUS_PUBLICHED
            ]);

            $pageInstance = PageInstance::create([
                'page_id' =>$page->id,
                'name' => 'Index page',
                'slug' => 'index',
                'template' => Template::INDEX_PAGE,
                'actual' => true
            ]);
        }
    }
}

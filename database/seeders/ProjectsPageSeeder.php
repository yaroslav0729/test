<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;

class ProjectsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=ProjectsPageSeeder
     * 
     * @return void
     */
    public function run()
    {
        $projectsPage = Page::where('type', Page::TYPE_PROJECTS_PAGE)->get();

        if (!count($projectsPage)) {

            $page = Page::create([
                'type' => Page::TYPE_PROJECTS_PAGE,
                'status' => Page::PAGE_STATUS_PUBLICHED
            ]);

            $pageInstance = PageInstance::create([
                'page_id' =>$page->id,
                'name' => 'Projects page',
                'slug' => 'donate',
                'template' => Template::PROJECTS_PAGE,
                'actual' => true
            ]);
        }
    }
}

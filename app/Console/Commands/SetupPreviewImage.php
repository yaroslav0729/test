<?php

namespace App\Console\Commands;
use App\Models\PageInstance;
use voku\helper\HtmlDomParser;

use Illuminate\Console\Command;

class SetupPreviewImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan setup_preview_images
     * 
     * @var string
     */
    protected $signature = 'setup_preview_images';

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
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Command started');

        $items = PageInstance::where('slug', 'like', '%' . 'media-centre/news/' . '%')->
        whereNull('preview_img')
        ->get();

        foreach ($items as $item) {
            $html = '';

            if (isset($item->parameters['main_html'])) {
                $html = $item->parameters['main_html'];
            }

            $document = new HtmlDomParser($html);
            $images = $this->findAllImages($document);

            if (count($images)) {
                $item->preview_img = $images[0];
                $item->save();
                 
                $this->info('Article id: ' . $item->id . ' saved');
            }
            
        }
         

        $this->info('Count pages: ' . $items->count());

        $this->info('Complete successfully!');
    }

    private function findAllImages($el)
    {
        $images = [];
        $imagesOrFalse = $el->findMultiOrFalse('img');

        if ($imagesOrFalse !== false) {
            foreach ($imagesOrFalse as $image) {
                $images[] = $image->getAttribute('src');
            }
        }

        return $images;
    }
}

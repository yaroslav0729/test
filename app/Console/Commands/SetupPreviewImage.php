<?php

namespace App\Console\Commands;

use App\Console\Commands\Parts\MediaParser2;
use App\Models\PageInstance;
use DB;
use Illuminate\Console\Command;
use voku\helper\HtmlDomParser;

class SetupPreviewImage extends Command
{
    protected $wpConnection;

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

        $this->wpConnection = DB::connection('wp');

        $parser = new MediaParser2($this->wpConnection);
        //$parser->parse();

        $parser->updateWpIdMediaCenter();

        //$this->setupFirstImage();

        $this->info('Complete successfully!');
    }

    protected function setupFirstImage()
    {
        $items = PageInstance::where('slug', 'like', '%' . 'media-centre/news/' . '%')->
            where(function ($query) {
                $query->whereNull('preview_img')
                    ->orWhere('preview_img', '');
            })->get();

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

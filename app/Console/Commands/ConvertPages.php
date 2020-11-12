<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ConvertPages extends Command
{
    const PARSING_LINK = 'https://www.islamichelp.org.uk/media-centre-sitemap.xml';

    /**
     * The name and signature of the console command.
     *
     * 
     * php artisan convert:media-center
     * 
     * @var string
     */
    protected $signature = 'convert:media-center';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pages parser';

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
        $this->info('Parsing process started');

        $response = Http::get(self::PARSING_LINK);

        dump($response->body());

        $this->info('Parsing process complete!!!');
    }
}

<?php

namespace Hgs3\Console\Commands;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm\GameMaker;
use Hgs3\Models\Orm\GamePlatform;
use Hgs3\Models\Orm\GameSeries;
use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\VersionUp\Master;
use Illuminate\Console\Command;
use Hgs3\Models\VersionUp\Database;

class Sitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create sitemap.xml';

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
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (env('APP_ENV') == 'production') {
            $this->error('productionでは実行できません');
            return;
        }

        $lastmod = '2018-05-19';


        $xml =<<< XML
<?xml version="1.0" encoding="UTF-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://horrorgame.net/</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/privacy</loc>
        <lastmod>2018-06-02</lastmod>
        <changefreq>never</changefreq>
        <priority>0.2</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/new_information</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>always</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/notice</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/game/soft</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/site</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/site/new_arrival</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/about</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.1</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/game/company</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/game/platform</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/game/series</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>

XML;

        $games = GameSoft::select(['id'])->get();

        foreach ($games as $game) {
            $xml .=<<< XML
    <url>
        <loc>https://horrorgame.net/game/soft/{$game->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/site/soft/{$game->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/review/soft/{$game->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://horrorgame.net/game/favorite/{$game->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

XML;
        }



        $companies = GameMaker::select(['id'])->get();
        foreach ($companies as $company) {
            $xml .=<<< XML
    <url>
        <loc>https://horrorgame.net/game/company/{$company->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.4</priority>
    </url>

XML;
        }

        $platforms = GamePlatform::select(['id'])->get();
        foreach ($platforms as $platform) {
            $xml .=<<< XML
    <url>
        <loc>https://horrorgame.net/game/platform/{$platform->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.4</priority>
    </url>

XML;
        }

        $series = GameSeries::select(['id'])->get();
        foreach ($series as $s) {
            $xml .=<<< XML
    <url>
        <loc>https://horrorgame.net/game/series/{$s->id}</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.4</priority>
    </url>

XML;
        }

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);
    }
}

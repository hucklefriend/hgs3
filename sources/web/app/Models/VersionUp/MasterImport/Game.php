<?php
/**
 * ゲームインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Game extends MasterImportAbstract
{
    public function import()
    {
        $path = resource_path('master/game');

        $files = File::files($path);

        $companies = $this->getCompanyHash();
        $platforms = $this->getPlatformHash();
        $series = $this->getSeriesHash();

        foreach ($files as $filePath) {
            $data = \GuzzleHttp\json_decode(File::get($filePath));

            $game = new Orm\Game;
            $game->name = $data->name;
            $game->phonetic = $data->phonetic;
            $game->phonetic_order = $data->phonetic;
            $game->genre = $data->genre;
            $game->company_id = $companies[$data->company] ?? null;

            if (isset($series[$data->series])) {
                $game->series_id = $series[$data->series];
            } else {
                $s = new Orm\GameSeries;
                $s->name = $data->series;
                $s->save();

                $game->series_id = $s->id;
                unset($s);
            }

            $game->save();



            $game->save(['timeline' => false]);

            unset($data);
        }
    }
}
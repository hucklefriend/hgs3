<?php

use Illuminate\Database\Seeder;

class GameMasterSeeder extends Seeder
{
    /**
     * マスターをインポート
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run()
    {
        \Hgs3\Models\VersionUp\Database::versionUp();

        // 開発環境でのみ有効
        $command = '/usr/bin/mysql -u root hgs3 < ' . storage_path('master/all/20180401.sql');
        exec($command);

        \Hgs3\Models\VersionUp\Master::import(20180401);
        \Hgs3\Models\VersionUp\Master::import(20180519);
    }
}

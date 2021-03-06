<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;
use Hgs3\Models\Test;

class SiteSeeder extends Seeder
{
    /**
     * サイトデータ生成
     *
     * @throws Exception
     */
    public function run()
    {
        DB::table('sites')->truncate();
        DB::table('site_new_arrivals')->truncate();
        DB::table('site_search_indices')->truncate();
        DB::table('site_handle_softs')->truncate();

        $users = Test\User::get();
        $maxUser = $users->count();

        $softIds = Test\GameSoft::getIds();
        $maxSoft = count($softIds) - 1;

        $rates = [0, 15, 18];

        for ($i = 0; $i < $maxUser; $i++) {
            $u = $users[$i];
            $n = rand(1, 3);

            for ($j = 0; $j < $n; $j++) {
                $orm = new Orm\Site();
                $orm->user_id = $u->id;
                $orm->name = self::getSampleTitle();
                $orm->url = 'https://horrorgame.net';
                $orm->presentation = self::getSampleText();
                $orm->rate = $rates[rand(0, 2)];
                $orm->main_contents_id = rand(1, 7);
                $orm->gender = rand(0, 2);
                $orm->open_type = 0;
                $orm->in_count = rand(0, 9999);
                $orm->out_count = rand(0, 9999);
                $orm->good_num = 0;
                $orm->bad_num = 0;
                $orm->registered_timestamp = time();
                $orm->updated_timestamp = time();

                $handleSoftNum = rand(5, 20);
                $handleSoft = '';
                for ($k = 0; $k < $handleSoftNum; $k++) {
                    $handleSoft .= $softIds[rand(0, $maxSoft)] . ',';
                }

                rtrim($handleSoft, ',');
                $orm->handle_soft = $handleSoft;

                if (rand(0, 100) > 90) {
                    $orm->hgs2_site_id = rand(1, 100);
                }

                \Hgs3\Models\Site::insert($u, $orm);

                if (rand(0, 10) > 2) {
                    $orm->list_banner_upload_flag = 1;
                    $orm->list_banner_url = self::getSampleSiteBanner();
                }

                if (rand(0, 10) > 2) {
                    $orm->detail_banner_upload_flag = 1;
                    $orm->detail_banner_url = self::getSampleSiteDetailBanner();
                }

                if ($orm->rate == 18) {
                    $orm->list_banner_upload_flag_r18 = 1;
                    $orm->list_banner_url_r18 = self::getSampleSiteBannerR18();

                    $orm->detail_banner_upload_flag_r18 = 1;
                    $orm->detail_banner_url_r18 = self::getSampleSiteDetailBannerR18();
                }

                $orm->save();

                //if (rand(0, 5) > 1) {
                    \Hgs3\Models\Site\Approval::approve($orm, '');
                //}

                if (mt_rand(0, 10) == 0) {
                    \Hgs3\Models\Site::update($u, $orm, null, null, 0, false, false);
                }

                unset($orm);
            }
        }
    }

    /**
     * サンプルタイトルを取得
     *
     * @return string
     */
    private static function getSampleTitle()
    {
        $titles = [
            /*'長い長い長い長い長い長い長い長い長い長い長い長い長い長テストサイト',
            '長い長い長い長い長い長い長い長い長い長い長い長い長い長テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            'テストサイト',*/
            'テストデータサイト',
            'テストサイト',
            'テストデータサイト',
            '長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い名前のサイト'
        ];

        $i = rand(0, count($titles) - 1);

        return $titles[$i];
    }

    /**
     * サンプルのテキストを取得
     *
     * @return string
     */
    private static function getSampleText()
    {
        $footer =<<< FOOTER
テスト用のサイトデータです。
このデータは本運営開始時に削除されます。
        
テストデータのバナーは下記のサイトから利用させていただいております。

超シンプル素材集
http://sozai.akuseru-design.com/

素材屋 flower&clover
https://fc.ashrose.net/
FOOTER;

        return $footer;
    }

    private static function getSampleSiteBanner()
    {
        $banners = [
            'ban01.gif',
            'ban01.jpg',
            'ban02.gif',
            'ban03.jpg',
            'ban05.gif',
            'ban07.gif',
            'bnr016_02.gif',
            'bnr016_08.gif',
            'bnr017_06.gif',
            'bnr018_04.gif',
            'bnr018_08.gif',
            'bnr021_02.gif',
            'bnr021_07.gif',
            'bnr021_08.gif',
            'bnr022_04.gif',
            'bnr022_05.gif',
            'bnr023_01.gif',
            'bnr023_04.gif',
            'bnr023_08.gif',
            'bnr024_01.gif',
            'hageIMGL0634_TP_V.jpg',
            'SHIO16032459IMG_6994_TP_V.jpg',
            'smIMGL3631_TP_V.jpg',
            'smIMGL3765_TP_V4.jpg',
            'Yuu171226IMGL0058_TP_V.jpg'
        ];

        return 'https://horrorgame.net/img/test/site/list_banner/' . $banners[rand(0, count($banners) - 1)];
    }
    private static function getSampleSiteBannerR18()
    {
        $banners = [
            '001.jpg',
            '002.jpg',
            '003.jpg',
            '004.gif'
        ];

        return 'https://beta.horrorgame.net/img/test/site/list_banner_r18/' . $banners[rand(0, count($banners) - 1)];
    }

    private static function getSampleSiteDetailBanner()
    {
        $banners = [
            'd002.jpg',
            'd003.jpg',
            'd004.jpg',
            'd005.jpg',
            'd006.gif',
            'xmas.jpg',
            'hageIMGL0634_TP_V.jpg',
            'SHIO16032459IMG_6994_TP_V.jpg',
            'smIMGL3631_TP_V.jpg',
            'smIMGL3765_TP_V4.jpg',
            'Yuu171226IMGL0058_TP_V.jpg'
        ];

        return 'https://horrorgame.net/img/test/site/detail_banner/' . $banners[rand(0, count($banners) - 1)];
    }

    private static function getSampleSiteDetailBannerR18()
    {
        $banners = [
            '001.jpg',
            '002.jpg',
            '003.jpg',
            '004.jpg'
        ];

        return 'https://beta.horrorgame.net/img/test/site/detail_banner_r18/' . $banners[rand(0, count($banners) - 1)];
    }
}

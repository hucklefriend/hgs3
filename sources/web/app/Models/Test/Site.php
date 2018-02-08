<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\Site\ApprovalStatus;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class Site
{
    /**
     * テストデータ生成
     *
     * @throws \Exception
     */
    public static function create()
    {
        echo 'create site test data.'.PHP_EOL;

        DB::table('sites')->truncate();
        DB::table('site_new_arrivals')->truncate();
        DB::table('site_search_indices')->truncate();
        DB::table('site_handle_softs')->truncate();

        $users = User::get();
        $maxUser = $users->count();

        $softIds = GameSoft::getIds();
        $maxSoft = count($softIds) - 1;

        $rates = [0, 15, 18];

        for ($i = 0; $i < $maxUser; $i++) {
            $u = $users[$i];
            $n = rand(5, 10);

            for ($j = 0; $j < $n; $j++) {
                $orm = new Orm\Site();
                $orm->user_id = $u->id;
                $orm->name = self::getSampleTitle();
                $orm->url = 'http://fake.' . str_random(rand(3, 10)) . '.com/';
                $orm->presentation = self::getSampleText();
                $orm->rate = $rates[rand(0, 2)];
                $orm->main_contents_id = rand(1, 7);
                $orm->gender = rand(1, 3);
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

                \Hgs3\Models\Site::save($u, $orm, null, null, rand(0, 100) > 80);

                $orm->list_banner_upload_flag = 1;
                $orm->list_banner_url = self::getSampleSiteBanner();
                $orm->save();

                unset($orm);
            }
        }
    }

    /**
     * サイトIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('sites')
            ->select('id')
            ->get()
            ->pluck('id');
    }

    /**
     * サンプルタイトルを取得
     *
     * @return string
     */
    private static function getSampleTitle()
    {
        $titles = [
            '香華園',
            'バイオハザードオルタナティブエディションthe攻略',
            'バイオハザード D・C　攻略：GAYM',
            'わいわい芸夢館',
            '南町奉行屯所',
            'KINCZEM',
            'ＧＯＭＢＥ',
            'Resident Evil Briefing',
            'バイオハザード4プレイ日記',
            'お絵描き部屋',
            '神・ゲーム堂',
            'ゲーム攻略・裏技 - GAME STAR',
            '澪つくし',
            '光と闇の楽園',
            'MILK COCOA',
            'RedChedar',
            '山村の部屋',
            'プシュケリア',
            '仮面ライダーバトル　ガンバライドＤＳ　攻略',
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
        $texts = [
            'ゲーム総合攻略サイトです。'.PHP_EOL.'ドラゴンクエスト、ファイナルファンタジー、バイオハザード、ポケモン、太鼓の達人など。'.PHP_EOL.'掲示板もあります。相互リンク募集中。',
            'GC版対応。'.PHP_EOL.'DISC1〜DISC2の攻略チャート、アイテムリスト、MAP、リーチハンター、小ネタ等',
            'PS4/PS3/PSV「ワンピース海賊無双3」のシリーズ総合攻略サイトです。'.PHP_EOL.'メインエピソード、仲間エピソードを詳細マップで解説。海賊無双1の攻略もあります。',
            'MOTHER・ポケモンを中心に、二次創作で絵を描いています。'.PHP_EOL.'ゲームするのが好きなので、ゲームの感想・自分用のデータ・思い出なども少し。'.PHP_EOL.'まったりのんびり更新しています。',
            'アトラス中心（メガテン・ペルソナ・ＢＵＳＩＮ・ライドウ）、バイオハザード、ＦＦの絵・漫画サイト。'.PHP_EOL.'最近はツイッタが主ですが落書きアップは続けてます。',
            'バイオハザードの二次創作小説がメイン。'.PHP_EOL.'男女カップリングと傭兵話が多めで、シリアス＆ハードボイルドな作風です。',
            'ゲーム内の景色や小道具や小ネタ等をライフルで拡大して見たり、のんびりと雰囲気を楽しんだりしています。'.PHP_EOL.'メインはバイオハザードシリーズですが他にはSAWやサイレントヒル,USJホラーナイトレポ等もあります。',
            '軍人の筋肉スキーな私が好き勝手描き散らかしてるイラスト展示サイトです。'.PHP_EOL.'年齢層高めで運営しております。'.PHP_EOL.'出来たてなので作品はまだ少ないですが地道に増やしていく予定です、よろしくお願いします。',
            '好きなものを好きなだけらくがきしてる雑多ジャンルサイトです。'.PHP_EOL.'ここ最近はポップンが多めかもしれません。女性向け寄りです。',
            '絵を描いたり叫んだりするファンブログです。'.PHP_EOL.'今はバイオとモンハンがアツい。'.PHP_EOL.'ピアクリがすごく好き。'.PHP_EOL.'アイルーちゃんも好き（ケモショタ的な意味で）。'.PHP_EOL.'成人向け＆女性向けコンテンツ含みます。',
            'バイオハザード中心、ブラックジャックちょっと置いてあります。'.PHP_EOL.'管理人の気分のままに絵が置いてあります。',
            'アクションアドベンチャー、ＦＰＳ攻略サイト。バイオハザード、メタルギアソリッド、call of duty等を５８作攻略完了。',
            'とことん攻略、困った時の攻略ページです',
            '愛楽ゆにが創作したイラスト・ゲーム・ストーリーCG集の他、初心者講座などを掲載しています。また、アニメ・ゲームの紹介もしています。',
            '移転。更新は休止しています。レトロゲームをメインにイラスト/壁紙/漫画/攻略/考察/裏技集等.アルカエスト/樹帝戦紀/桜国ガイスト/神聖紀オデッセリア/黒の断章/野々村病院の人々/ブレイズ＆ブレイド他.',
            'アオイシロ、アカイイト、D.C.(ダ・カーポ)、φなる・あぷろーち、Memories off(メモリーズオフ)シリーズ等の攻略サイト。ゲームの紹介や感想、最新のアニメ情報もあります。最近はアプリゲームの攻略も。'
        ];

        $i = rand(0, count($texts) - 1);

        return $texts[$i];
    }

    private static function getSampleSiteBanner()
    {
        $banners = [
            'banner (1).gif',
            'banner (1).jpg',
            'banner (1).png',
            'banner.gif',
            'banner.jpg',
            'banner.png',
            'bn200.gif',
            'rindoutei7.gif',
            'satopian_bn.jpg',
        ];

        return url('img/site_banner/test/' . $banners[rand(0, count($banners) - 1)]);
    }

    /**
     * サイトORMの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return Orm\Site::all();
    }

    /**
     * 承認済みサイトORMの配列を取得
     *
     * @return array
     */
    public static function getOpen()
    {
        return Orm\Site::where('approval_status', ApprovalStatus::OK)
            ->get();
    }
}
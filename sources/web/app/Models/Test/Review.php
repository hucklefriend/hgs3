<?php
/**
 * レビュー
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Review
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        echo 'create review test data.'.PHP_EOL;

        $users = User::get();
        $packages = Package::get();
        $packageLinkHash = Package::getLinkHash();

        $userMax = count($users) - 1;
        $packageMax = count($packages) - 1;

        $r = new \Hgs3\Models\Review();

        for ($i = 0; $i < $num; $i++) {
            $pkg = $packages[rand(0, $packageMax)];
            $user = $users[rand(0, $userMax)];

            $draft = new Orm\ReviewDraft([
                'fear'            => rand(0, 5),
                'story'           => rand(0, 5),
                'volume'          => rand(0, 5),
                'difficulty'      => rand(0, 5),
                'graphic'         => rand(0, 5),
                'sound'           => rand(0, 5),
                'crowded'         => rand(0, 5),
                'controllability' => rand(0, 5),
                'recommend'       => rand(0, 5),
                'is_spoiler'      => rand(0, 1),
                'progress'        => str_random(rand(50, 300)),
                'text'            => self::getSampleReview(),
                'title'           => self::getSampleTitle(),
                'post_date'       => new \DateTime()
            ]);

            $draft->user_id = $user->id;
            $draft->soft_id = $packageLinkHash[$pkg->id];
            $draft->package_id = $pkg->id;

            $r->save($user, $draft);
            unset($orm);
        }

        unset($users);
        unset($pkgs);

        $softIds = GameSoft::getIds();
        foreach ($softIds as $softId) {
            Orm\ReviewTotal::calculate($softId);
        }

        unset($softIds);
    }

    /**
     * サンプルのタイトルを取得
     *
     * @return string
     */
    private static function getSampleTitle()
    {
        $titles = [
            '名作。としかいいようがありません。',
            'ゴア表現なしでも面白い',
            'バグで全てが台無し',
            '良い意味で裏切られるゲーム',
            '騒げるゲームが好きな方にオススメ',
            '待ってました',
            'ゲームとしてはいいと思うんだ',
            '典型的なDLCの悪い例',
            'ボリュームはおねだん以上',
            '期待し過ぎた。',
            'これは酷い',
            '評判よりはいい出来で面白い。',
            '期待していただけに・・・',
            '想像以上のマイナー感',
            '色々物足りない惜しい作品',
            '細かい部分までしっかりと作られている大作',
            'またいつものやつ。',
            'シリーズでは2しかやったことがない者から見て',
            'アメコミ原作のハリウッド映画風ヒーローのゲーム',
        ];

        $i = rand(0, count($titles) - 1);

        return $titles[$i];
    }

    /**
     * サンプルのレビューを取得
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private static function getSampleReview()
    {
        $path = storage_path('test/review');

        $files = File::files($path);

        return File::get($files[rand(0, count($files) - 1)]);
    }

    /**
     * レビューIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('reviews')
            ->select('id')
            ->get()
            ->pluck('id');
    }

    /**
     * レビューの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return Orm\Review::all();
    }
}
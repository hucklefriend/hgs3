<?php

use Illuminate\Database\Seeder;
use Hgs3\Models\Test;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        $users = Test\User::get();

        $soft = Test\GameSoft::get();
        $softNum = $soft->count();

        foreach ($users as $user) {
            $num = rand(0, 10);
            $written = [];

            for ($i = 0; $i < $num; $i++) {
                $s = $soft[rand(0, $softNum - 1)];

                if (isset($written[$s->id])) {
                    continue;
                }

                $draft = self::generateDraft($user, $s);
                if ($draft === false) {
                    continue;
                }

                \Hgs3\Models\Review::open($s, $draft);
            }
        }
    }

    /**
     * 下書きを作成
     *
     * @param \Hgs3\Models\User $user
     * @param \Hgs3\Models\Orm\GameSoft $soft
     * @return bool|\Hgs3\Models\Orm\ReviewDraft
     * @throws Exception
     */
    private static function generateDraft(Hgs3\Models\User $user, Hgs3\Models\Orm\GameSoft $soft)
    {
        $fileName = rand(1, 9) . '.txt';
        $draft = new Hgs3\Models\Orm\ReviewDraft();

        $packageIds = Test\GameSoft::getPackageIds($soft->id);
        echo json_encode($packageIds) . PHP_EOL;
        if (empty($packageIds)) {
            return false;
        }

        $pkg = [$packageIds[0]];
        for ($i = 1; $i < count($packageIds) - 1; $i++) {
            if (rand(0, 100) < 20) {
                $pkg[] = $packageIds[$i];
            }
        }

        $draft->user_id = $user->id;
        $draft->soft_id = $soft->id;
        $draft->package_id = json_encode($pkg);
        $draft->fear = rand(0, 6);
        $draft->url = rand(0, 1) ? '' : 'https://horrorgame.net/';
        $draft->progress = rand(0, 1) ? '' : '進捗状況';
        $draft->good_comment = file_get_contents(storage_path('test/review/good/' . $fileName));
        $draft->bad_comment = file_get_contents(storage_path('test/review/bad/' . $fileName));
        $draft->general_comment = file_get_contents(storage_path('test/review/general/' . $fileName));
        $draft->is_spoiler = rand(0, 1);

        $goodTags = [];
        $veryGoodTags = [];
        $badTags = [];
        $veryBadTags = [];

        foreach (Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName) {
            if (rand(0, 10) < 4) {
                $goodTags[] = $tagId;
                if (rand(0, 10) < 3) {
                    $veryGoodTags[] = $tagId;
                }
            }

            if (rand(0, 10) < 4) {
                $badTags[] = $tagId;
                if (rand(0, 10) < 3) {
                    $veryBadTags[] = $tagId;
                }
            }
        }

        \Hgs3\Models\Review::saveDraft($draft, $goodTags, $veryGoodTags, $badTags, $veryBadTags);

        return $draft;
    }
}

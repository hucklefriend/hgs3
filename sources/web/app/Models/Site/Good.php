<?php
/**
 * サイトへのいいね
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\Timeline;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Good
{
    /**
     * いいね済みか？
     *
     * @param Orm\Site $site
     * @param User $user
     * @return bool
     */
    public function isGood(Orm\Site $site, User $user)
    {
        $num = DB::table('site_good_histories')
            ->where('site_id', $site->id)
            ->where('user_id', $user->id)
            ->count(['site_id']);

        return $num > 0;
    }

    /**
     * いいね実行
     *
     * @param Orm\Site $site
     * @param User $user
     * @return bool
     */
    public function good(Orm\Site $site, User $user)
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');

        // 現在の最大いいね数を覚えておく(タイムライン用)
        $maxGoodNum = $site->max_good_num;

        DB::beginTransaction();
        try  {
            // サイトのいいね数を更新
            $site->good_num++;
            if ($site->good_num > $site->max_good_num) {
                $site->max_good_num = $site->good_num;
            }
            $site->save();

            // いいね履歴に保存
            DB::table('site_good_histories')
                ->insert([
                    'user_id'    => $user->id,
                    'site_id'    => $site->id,
                    'good_date'  => $now,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

            // いいねしたことがあるかの保存
            $sql =<<< SQL
INSERT IGNORE INTO site_goods (user_id, site_id, created_at, updated_at)
VALUES(?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) 
SQL;

            DB::insert($sql, [$user->id, $site->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // タイムライン
        Timeline\ToMe::addSiteFavoriteText($site->user_id, $site->id, $site->name, $user->id, $user->name);
        Timeline\FavoriteSite::addGoodNumText($site->id, $site->name, $site->good_num, $maxGoodNum);

        return true;
    }

    /**
     * いいね取り消し
     *
     * @param Orm\Site $site
     * @param User $user
     * @return bool
     */
    public function cancelGood(Orm\Site $site, User $user)
    {
        // いいね数を減らす
        $site->good_num--;

        // 念のため…いらないかも
        if ($site->good_num < 0) {
            $site->good_num = 0;
        }

        DB::beginTransaction();
        try  {
            $site->save();

            DB::table('site_good_histories')
                ->where('site_id', $site->id)
                ->where('user_id', $user->id)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}
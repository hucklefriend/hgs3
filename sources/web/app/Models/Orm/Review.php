<?php
/**
 * ORM: reviews
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;
use Hgs3\Log;

class Review extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * 保存
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $isNew = $this->id === null;

        // ポイントは怖さ値×4+それ以外の値の合算×2
        $this->calcPoint();

        if ($isNew) {
            // 新規登録
            $this->sort_order = 0;
            $this->good_num = 0;
            $this->post_at = new \DateTime();
            $this->update_num = 0;
        } else {
            // データ修正
            $this->update_num++;
        }

        return parent::save($options);
    }

    /**
     * ポイントの計算
     */
    public function calcPoint()
    {
        $this->point =
            $this->fear * 5 + ($this->good_tag_num + $this->very_good_tag_num * 2) -
            ($this->bad_tag_num + $this->very_bad_tag_num * 2);
    }

    /**
     *
     */
    public function delete()
    {
        DB::beginTransaction();
        try {
            // 履歴を削除
            ReviewGoodHistory::where('review_id')
                ->delete();

            // TODO 不正報告を削除

            $gameId = $this->gameId;
            parent::delete();

            // 累計データの修正
            ReviewTotal::calculate($gameId);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    /**
     * 特定ユーザーが持っているサイト数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->count('id');
    }
}

<?php
/**
 * ORM: reviews
 */

namespace Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $this->post_date = new \DateTime();
            $this->update_num = 0;
        } else {
            // データ修正
            $this->update_num++;
        }

        DB::beginTransaction();
        try {
            parent::save($options);

            // 累計データ
            ReviewTotal::calculate($this->game_id);

            if ($isNew) {
                // 下書き削除
                DB::table('review_drafts')
                    ->where('user_id', $this->user_id)
                    ->where('game_id', $this->game_id)
                    ->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        if ($isNew) {
            Timeline\Game::addNewReviewText($this->game_id, null, $this->id, $this->is_spoiler);
        }

        return true;
    }

    /**
     * ポイントの計算
     */
    public function calcPoint()
    {
        $this->point =
            $this->fear * 4 + ($this->story + $this->volume + $this->difficulty +
                $this->graphic + $this->sound + $this->crowded + $this->controllability + $this->recommend) * 2;
    }

    /**
     * 同じゲームの下書きを取得
     *
     * @param $userId
     * @param $gameId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getHashByGame($userId, $gameId)
    {
        $data = self::where('user_id', $userId)
            ->select(['id', 'package_id'])
            ->where('game_id', $gameId)
            ->get();

        $result = [];
        foreach ($data as $row) {
            $result[$row->package_id] = $row->id;
        }

        unset($data);

        return $result;
    }

    /**
     * いいね履歴を取得する
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGoodHistory()
    {
        return DB::table('review_good_histories')
            ->where('review_id', $this->id)
            ->orderBy('good_date', 'DESC')
            ->paginate(20);
    }

    /**
     * 削除
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

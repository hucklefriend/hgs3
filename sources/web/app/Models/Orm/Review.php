<?php
/**
 * ORM: reviews
 */

namespace Hgs3\Models\Orm;
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
        // ポイントは怖さ値×4+それ以外の値の合算×2
        $this->calcPoint();

        $this->sort_order = 0;
        $this->good_num = 0;
        $this->post_date = new \DateTime();
        $this->update_num = 0;

        return parent::save($options);
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

            parent::delete();

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

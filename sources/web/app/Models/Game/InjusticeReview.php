<?php
/**
 * 不正レビューモデル
 */


namespace Hgs3\Models\Game;

use Hgs3\User;
use Illuminate\Support\Facades\DB;

class InjusticeReview
{
    /**
     * 不正レビュー一覧データを取得
     *
     * @return array
     */
    public function getList()
    {
        $data = DB::table('injustice_reviews')
            ->paginate();
        if (empty($data)) {
            return ['data' => null];
        }

        $userIds = array_pluck($data->items(), 'user_id');
        $reviewIds = array_pluck($data->items(), 'review_id');
        $reviews = \Hgs3\Models\Orm\Review::whereIn('id', $reviewIds)->get();
        $userIds = array_merge($userIds, $reviews->pluck('user_id'));

        return [
            'data' => $data,
            'users' => User::getNameHash($userIds),
            'reviews' => $reviews
        ];
    }
}
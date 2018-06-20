<?php
/**
 * お気に入りゲーム
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserFavoriteSoft extends \Eloquent
{
    /**
     * 特定ユーザーのデータ数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->count('id');
    }

    public static function getOpenProfileUserList($page, $num, $softId)
    {
        if (Auth::check()) {
            $where = 'WHERE open_profile_flag IN (1, 2)';
        } else {
            $where = 'WHERE open_profile_flag = 2';
        }

        $offset = ($page - 1) * $num;

        $sql =<<< SQL
SELECT user_id, UNIX_TIMESTAMP(created_at) AS register_timestamp,
  users.*
FROM
  (SELECT user_id, created_at FROM user_favorite_softs WHERE soft_id = :soft_id) fav
  INNER JOIN (
    SELECT `name`, show_id, icon_upload_flag, icon_file_name, icon_round_type
    FROM users
    {$where}
  ) users ON users.id = fav.user_id
LIMIT $num
OFFSET $offset
SQL;


        return DB::select($sql, ['soft_id' => $softId]);
    }
}

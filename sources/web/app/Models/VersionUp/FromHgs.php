<?php
/**
 * H.G.S.からユーザーデータを移行
 */

namespace Hgs3\Models\VersionUp;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Constants\Site\OpenType;
use Hgs3\Constants\SocialSite;
use Hgs3\Models\Site;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class FromHgs
{
    /**
     * 移行
     */
    public static function translate()
    {
        $sql =<<< SQL
SELECT * FROM hgs2.hgs_u_user
WHERE id <> 254
SQL;

        $deleteList = [5, 9, 10, 14, 16, 21, 22, 24, 33, 42, 43, 47, 57,
            56, 66, 72, 69, 68, 67, 78, 79, 82, 83, 84, 85, 94, 96, 98,
            107, 110, 111, 117, 118, 120, 131, 128, 132, 135, 141, 149,
            142, 155, 168, 172, 173, 174, 175, 185, 188, 196, 201, 218,
            219, 225, 226, 228, 176, 240, 234, 80, 235, 236, 237, 244,
            221, 148, 205, 238, 264, 272, 325, 305, 302, 300, 299, 296,
            289, 286, 282, 281, 277, 275, 274, 272, 266, 264, 263, 261,
            260,
        ];

        $hgsUsers = DB::select($sql);
        foreach ($hgsUsers as $hgsUser) {
            // HGNにユーザーとして登録
            $user = self::register($hgsUser);

            // サイト情報を取得
            $hgsSites = self::getSites($hgsUser->id);
            foreach ($hgsSites as $hgsSite) {
                if (in_array($hgsSite->id, $deleteList)) {
                    continue;
                }
                self::saveSite($user, $hgsSite);
            }
        }
    }

    private static function register($hgsUser)
    {
        $signUpAt = $hgsUser->registered_date;
        if ($signUpAt == 0) {
            // yomi-search時代のユーザーは一律でH.G.S.開始日時とする
            $signUpAt = strtotime('2003-09-28 00:00:00');
        }

        $data = [
            'name'       => $hgsUser->name,
            'email'      => $hgsUser->mail,
            'password'   => str_random(),
            'sign_up_at' => date('Y-m-d H:i:s', $signUpAt)
        ];

        $newUser = User::register($data);

        $newUser->adult = $hgsUser->over18;
        $newUser->last_login_at = date('Y-m-d H:i:s', $hgsUser->last_login);
        $newUser->hgs12_user    = 1;

        // アイコンどうしよっか
        //$newUser->icon_file_name = $hgsUser->icon_url;

        $newUser->save();

        if ($newUser->email != null) {
            Orm\IgnoreProvisionalRegistrations::ignoreInsert($newUser->email);
        }

        // Twitter
        if ($hgsUser->twitter_id != null) {
            $sa = new Orm\SocialAccount;

            $sa->user_id = $newUser->id;
            $sa->social_site_id = SocialSite::TWITTER;
            $sa->social_user_id = $hgsUser->twitter_id;
            $sa->token = null;
            $sa->token_secret = null;
            $sa->nickname = null;
            $sa->name = null;
            $sa->save();
        }

        return $newUser;
    }


    private static function getSites($userId)
    {
        $sql =<<< SQL
SELECT * FROM hgs2.hgs_u_site
WHERE user_id = ?
SQL;

        return DB::select($sql, [$userId]);
    }

    private static function saveSite(User $user, $hgsSite)
    {
        $sqlHandleGame =<<< SQL
SELECT * FROM hgs2.hgs_u_site_handle_game
WHERE site_id = ?
SQL;

        $handleGames = DB::select($sqlHandleGame, [$hgsSite->id]);     // 取扱いゲーム
        if (!empty($handleGames)) {
            $handleGames = array_pluck($handleGames, 'soft_id');
        }

        $site = new Orm\Site;
        $site->user_id = $user->id;
        $site->name = $hgsSite->site_name;
        $site->url = $hgsSite->url;
        $site->list_banner_upload_flag = 1;
        $site->list_banner_url = $hgsSite->banner_url;
        $site->detail_banner_upload_flag = 0;
        $site->detail_banner_url = null;
        $site->presentation = $hgsSite->presentation;
        $site->handle_soft = \json_encode($handleGames);
        $site->rate = $hgsSite->rate;
        $site->gender = $hgsSite->gender;
        $site->main_contents_id = $hgsSite->main_contents;
        $site->open_type = OpenType::ALL;
        $site->in_count = $hgsSite->in;
        $site->out_count = $hgsSite->out;
        $site->approval_status = ApprovalStatus::OK;
        $site->registered_timestamp = $hgsSite->registered_date;
        $site->updated_timestamp = $hgsSite->updated_date;
        $site->hgs2_site_id = $hgsSite->id;

        if (starts_with($site->list_banner_url, '/uploader/banner/id/')) {
            $bannerId = substr($site->list_banner_url, 20);
            $sql = 'SELECT path FROM hgs2.hgs_u_upload WHERE id = ?';
            $path = DB::select($sql, [$bannerId]);

            if (empty($path)) {
                $site->list_banner_upload_flag = 0;
                $site->list_banner_url = null;
            } else {
                $name = substr($path[0]->path, 8);
                $site->list_banner_url = 'https://horrorgame.net/img/hgs_banner/' . $name . '.jpg';
            }
        }

        $site->save();

        Site::saveHandleSofts($site, $handleGames);     // 取扱いゲームの保存
        Site::saveSearchIndex($site, $handleGames);     // 検索インデックス更新

        DB::table('site_search_indices')
            ->where('site_id', $site->id)
            ->update(['updated_timestamp' => $site->updated_timestamp]);

        $sqlDailyAccess =<<< SQL
INSERT INTO site_daily_accesses (site_id, `date`, in_count, out_count, created_at, updated_at)
SELECT
  {$site->id} AS site_id
  , DATE_FORMAT(FROM_UNIXTIME(`day`), '%Y%m%d') AS `date`
  , `in` AS in_count
  , `out` AS out_count
  , FROM_UNIXTIME(`registered_date`) AS created_at
  , FROM_UNIXTIME(`updated_date`) AS created_at
FROM hgs2.hgs_u_site_access_daily
WHERE site_id = ?
ORDER BY `day`
SQL;
        DB::insert($sqlDailyAccess, [$hgsSite->id]);
    }
}
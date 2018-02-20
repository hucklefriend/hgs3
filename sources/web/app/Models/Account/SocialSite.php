<?php
/**
 * ソーシャルサイトモデル
 */

namespace Hgs3\Models\Account;

use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class SocialSite
{
    public function has($socialSiteId, $userId)
    {
        return DB::table('social_accounts')
            ->where('user_id', $userId)
            ->where('social_site_id', $socialSiteId)
            ->count('id') > 0;
    }

    /**
     * ソーシャルアカウント情報を取得
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAccounts(User $user)
    {
        return Orm\SocialAccount::where('user_id', $user->id)
            ->orderBy('social_site_id')
            ->get();
    }

    public static function getGroupedAccounts(User $user)
    {
        $data = self::getAccounts($user);

        $result = [];

        foreach ($data as $account) {
            $result[$account->social_site_id][] = $account;
        }

        return $result;
    }
}
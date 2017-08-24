<?php
/**
 * ソーシャルサイトモデル
 */

namespace Hgs3\Models\Account;
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
}
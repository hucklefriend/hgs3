<?php
/**
 * ソーシャルサイト
 */

namespace Hgs3\Constants;

use Illuminate\Support\HtmlString;

class SocialSite
{
    const MAIL = 0;     // サイトじゃないけど…
    const TWITTER = 1;
    const FACEBOOK = 2;
    const GOOGLE_PLUS = 3;
    const GITHUB = 4;

    /**
     * アイコン用タグを取得
     *
     * @param $socialSiteId
     * @return HtmlString
     */
    public static function getIcon($socialSiteId)
    {
        $tag = '';

        switch ($socialSiteId) {
            case self::MAIL:
                $tag = '<span class="color-mail"><i class="far fa-envelope"></i></span>';
                break;
            case self::TWITTER:
                $tag = '<span class="color-twitter"><i class="fab fa-twitter"></i></span>';
                break;
            case self::FACEBOOK:
                $tag = '<span class="color-facebook"><i class="fab fa-facebook"></i></span>';
                break;
            case self::GOOGLE_PLUS:
                $tag = '<span class="color-google"><i class="fab fa-google-plus-g"></i></span>';
                break;
            case self::GITHUB:
                $tag = '<span class="color-github"><i class="fab fa-github"></i></span>';
                break;
        }

        return new HtmlString($tag);
    }
}
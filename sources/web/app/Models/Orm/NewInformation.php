<?php
/**
 * 新着情報モデル
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\NewInformationText;
use Hgs3\User;

class NewInformation extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * ページャーを取得
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPager()
    {
        return self::orderBy('id', 'DESC')
            ->paginate(20);
    }

    /**
     * ページャー用データを取得
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $pager
     * @return array
     */
    public static function getPagerData(\Illuminate\Contracts\Pagination\LengthAwarePaginator $pager)
    {
        $data = [];

        $data['game_hash'] = GameSoft::getNameHash(array_pluck($pager->items(), 'game_id'));
        $data['site_hash'] = Site::getNameHash(array_pluck($pager->items(), 'site_id'));

        return $data;
    }

    public static function addNewGame($gameId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::NEW_GAME;
        $orm->soft_id = $gameId;
        $orm->date_time = new \DateTime();
        $orm->save();
    }

    public static function addNewSite($siteId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::NEW_SITE;
        $orm->site_id = $siteId;
        $orm->date_time = new \DateTime();
        $orm->save();
    }

    public static function addUpdateSite($siteId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::UPDATE_SITE;
        $orm->site_id = $siteId;
        $orm->date_time = new \DateTime();
        $orm->save();
    }

    public static function addNewReview($gameId, $reviewId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::UPDATE_SITE;
        $orm->game_id = $gameId;
        $orm->review_id = $reviewId;
        $orm->date_time = new \DateTime();
        $orm->save();
    }
}
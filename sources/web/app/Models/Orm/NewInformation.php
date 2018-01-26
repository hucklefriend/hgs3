<?php
/**
 * 新着情報モデル
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\NewInformationText;

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

        $data['gameHash'] = GameSoft::getNameHash(array_pluck($pager->items(), 'game_id'));
        $data['siteHash'] = Site::getNameHash(array_pluck($pager->items(), 'site_id'));

        return $data;
    }

    /**
     * 新着ゲーム
     *
     * @param int $softId
     */
    public static function addNewGame($softId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::NEW_GAME;
        $orm->soft_id = $softId;
        $orm->open_at = new \DateTime();
        $orm->save();
    }

    /**
     * 新着サイト
     *
     * @param $siteId
     */
    public static function addNewSite($siteId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::NEW_SITE;
        $orm->site_id = $siteId;
        $orm->open_at = new \DateTime();
        $orm->save();
    }

    /**
     * 更新サイト
     *
     * @param $siteId
     */
    public static function addUpdateSite($siteId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::UPDATE_SITE;
        $orm->site_id = $siteId;
        $orm->open_at = new \DateTime();
        $orm->save();
    }

    /**
     * 新着レビュー
     *
     * @param $gameId
     * @param $reviewId
     */
    public static function addNewReview($gameId, $reviewId)
    {
        $orm = new self();
        $orm->text_type = NewInformationText::UPDATE_SITE;
        $orm->game_id = $gameId;
        $orm->review_id = $reviewId;
        $orm->open_at = new \DateTime();
        $orm->save();
    }
}
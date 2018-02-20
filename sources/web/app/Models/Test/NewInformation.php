<?php
/**
 * 新着情報のテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\NewInformationText;
use Illuminate\Support\Facades\DB;

class NewInformation
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        echo 'create new information test data.'.PHP_EOL;

        $types = [
            NewInformationText::NEW_GAME,
            NewInformationText::NEW_SITE,
            NewInformationText::UPDATE_SITE,
            NewInformationText::NEW_REVIEW,
        ];
        $typeIndex = count($types) - 1;

        $softIds = GameSoft::getIds();
        $softIdsMax = count($softIds) - 1;

        $userIds = User::getIds();
        $userIdsMax = count($userIds) - 1;

        $siteIds = Site::getIds();
        $siteIdsMax = count($siteIds) - 1;

        $reviewIds = Review::getIds();
        $reviewIdsMax = count($reviewIds) - 1;


        for ($i = 0; $i < $num; $i++) {
            $type = $types[rand(0, $typeIdx)];
            //$game_ids[rand(0, $game_ids_max)]
            //$user_ids[rand(0, $user_ids_max)]
            //$site_ids[rand(0, $site_ids_max)]
            //$review_ids[rand(0, $review_ids_max)]

            switch ($type) {
                case NewInformationText::NEW_GAME:
                    \Hgs3\Models\Orm\NewInformation::addNewGame($softIds[rand(0, $softIdsMax)]);
                    break;
                case NewInformationText::NEW_SITE:
                    \Hgs3\Models\Orm\NewInformation::addNewSite($siteIds[rand(0, $siteIdsMax)]);
                    break;
                case NewInformationText::UPDATE_SITE:
                    \Hgs3\Models\Orm\NewInformation::addUpdateSite($siteIds[rand(0, $siteIdsMax)]);
                    break;
                case NewInformationText::NEW_REVIEW:
                    \Hgs3\Models\Orm\NewInformation::addNewReview($softIds[rand(0, $softIdsMax)], $reviewIds[rand(0, $reviewIdsMax)]);
                    break;
            }
        }
    }
}
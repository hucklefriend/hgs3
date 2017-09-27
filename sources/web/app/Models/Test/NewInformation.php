<?php
/**
 * 新着情報のテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\NewInformationText;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class NewInformation
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        $types = [
            NewInformationText::NEW_GAME,
            NewInformationText::NEW_SITE,
            NewInformationText::UPDATE_SITE,
            NewInformationText::NEW_REVIEW,
            //NewInformationText::NEW_DIARY,
        ];
        $type_idx = count($types) - 1;

        $game_ids = Game::getIds();
        $game_ids_max = count($game_ids) - 1;

        $user_ids = User::getIds();
        $user_ids_max = count($user_ids) - 1;

        $site_ids = Site::getIds();
        $site_ids_max = count($site_ids) - 1;

        $review_ids = Review::getIds();
        $review_ids_max = count($review_ids) - 1;


        for ($i = 0; $i < $num; $i++) {
            $type = $types[rand(0, $type_idx)];
            //$game_ids[rand(0, $game_ids_max)]
            //$user_ids[rand(0, $user_ids_max)]
            //$user_community_ids[rand(0, $user_community_ids_max)]
            //$site_ids[rand(0, $site_ids_max)]
            //$review_ids[rand(0, $review_ids_max)]

            switch ($type) {
                case NewInformationText::NEW_GAME:
                    \Hgs3\Models\Orm\NewInformation::addNewGame($game_ids[rand(0, $game_ids_max)]);
                    break;
                case NewInformationText::NEW_SITE:
                    \Hgs3\Models\Orm\NewInformation::addNewSite($site_ids[rand(0, $site_ids_max)]);
                    break;
                case NewInformationText::UPDATE_SITE:
                    \Hgs3\Models\Orm\NewInformation::addUpdateSite($site_ids[rand(0, $site_ids_max)]);
                    break;
                case NewInformationText::NEW_REVIEW:
                    \Hgs3\Models\Orm\NewInformation::addNewReview($game_ids[rand(0, $game_ids_max)], $review_ids[rand(0, $review_ids_max)]);
                    break;
            }
        }
    }
}
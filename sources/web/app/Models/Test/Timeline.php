<?php
/**
 * タイムラインのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\TimelineType;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Timeline
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        $tl_types = [
            TimelineType::NEW_GAME_SOFT,
            TimelineType::UPDATE_GAME_SOFT,
            TimelineType::FAVORITE_GAME,
            TimelineType::NEW_SITE,
            TimelineType::UPDATE_SITE,
            TimelineType::NEW_REVIEW,
            TimelineType::REVIEW_GOOD,
            TimelineType::NEW_USER_COMMUNITY_MEMBER,
            TimelineType::NEW_GAME_COMMUNITY_MEMBER,
            TimelineType::NEW_FOLLOWER,
        ];
        $type_idx = count($tl_types) - 1;

        $game_ids = Game::getIds();
        $game_ids_max = count($game_ids) - 1;

        $user_ids = User::getIds();
        $user_ids_max = count($user_ids) - 1;

        $user_community_ids = UserCommunity::getIds();
        $user_community_ids_max = count($user_community_ids) - 1;

        $site_ids = Site::getIds();
        $site_ids_max = count($site_ids) - 1;

        $review_ids = Review::getIds();
        $review_ids_max = count($review_ids) - 1;


        for ($i = 0; $i < $num; $i++) {
            $type = $tl_types[rand(0, $type_idx)];
            //$game_ids[rand(0, $game_ids_max)]
            //$user_ids[rand(0, $user_ids_max)]
            //$user_community_ids[rand(0, $user_community_ids_max)]
            //$site_ids[rand(0, $site_ids_max)]
            //$review_ids[rand(0, $review_ids_max)]

            switch ($type) {
                case TimelineType::NEW_GAME_SOFT:
                    \Hgs3\Models\Timeline::addNewGameSoftText($game_ids[rand(0, $game_ids_max)], null);
                    break;
                case TimelineType::UPDATE_GAME_SOFT:
                    \Hgs3\Models\Timeline::addUpdateGameSoftText($game_ids[rand(0, $game_ids_max)], null);
                    break;
                case TimelineType::FAVORITE_GAME:
                    \Hgs3\Models\Timeline::addFavoriteGameText($game_ids[rand(0, $game_ids_max)], null, $user_ids[rand(0, $user_ids_max)], null);
                    break;
                case TimelineType::NEW_SITE:
                    \Hgs3\Models\Timeline::addNewSite($user_ids[rand(0, $user_ids_max)], null, $site_ids[rand(0, $site_ids_max)], null);
                    break;
                case TimelineType::UPDATE_SITE:
                    \Hgs3\Models\Timeline::addUpdateSite($user_ids[rand(0, $user_ids_max)], null, $site_ids[rand(0, $site_ids_max)], null);
                    break;
                case TimelineType::NEW_REVIEW:
                    \Hgs3\Models\Timeline::addNewReviewText($review_ids[rand(0, $review_ids_max)], $user_ids[rand(0, $user_ids_max)], null, $game_ids[rand(0, $game_ids_max)], null);
                    break;
                case TimelineType::REVIEW_GOOD:
                    \Hgs3\Models\Timeline::addReviewGoodText($review_ids[rand(0, $review_ids_max)], $user_ids[rand(0, $user_ids_max)], null, $user_ids[rand(0, $user_ids_max)]);
                    break;
                case TimelineType::NEW_USER_COMMUNITY_MEMBER:
                    \Hgs3\Models\Timeline::addNewUserCommunityMemberText($user_community_ids[rand(0, $user_community_ids_max)], null, $user_ids[rand(0, $user_ids_max)], null);
                    break;
                case TimelineType::NEW_GAME_COMMUNITY_MEMBER:
                    \Hgs3\Models\Timeline::addNewGameCommunityMemberText($game_ids[rand(0, $game_ids_max)], null, $user_ids[rand(0, $user_ids_max)], null);
                    break;
                case TimelineType::NEW_FOLLOWER:
                    \Hgs3\Models\Timeline::addNewFollower($user_ids[rand(0, $user_ids_max)], null, $user_ids[rand(0, $user_ids_max)]);
                    break;
            }
        }
    }
}
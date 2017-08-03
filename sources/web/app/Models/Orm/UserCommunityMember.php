<?php
/**
 * ORM user_community_member
 */

namespace Hgs3\Models\Orm;

class UserCommunityMember extends \Eloquent
{
    //
    protected $guarded = ['user_community_id', 'user_id'];
}

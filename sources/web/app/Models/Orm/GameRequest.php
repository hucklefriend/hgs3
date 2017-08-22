<?php

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GameRequest extends Model
{
    /**
     * コメント数を更新
     */
    public function updateCommentNum()
    {
        $num = DB::table('game_request_comments')
            ->where('game_request_id', $this->id)
            ->count('id');

        $this->comment_num = $num;
        $this->save();
    }
}

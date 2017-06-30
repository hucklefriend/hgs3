<?php

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameUpdateRequest;
use Illuminate\Support\Facades\DB;

class Request
{
    public function saveUpdateStatus(GameUpdateRequest $gur)
    {
        DB::beginTransaction();
        try {
            $gur->save();

            // ステータス

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
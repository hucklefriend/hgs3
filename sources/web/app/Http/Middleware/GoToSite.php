<?php
/**
 * サイト遷移用ミドルウェア
 */

namespace Hgs3\Http\Middleware;

use Closure;
use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Log;
use Hgs3\Models\Site;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;

class GoToSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * レスポンス送信後に処理
     *
     * @param $request
     * @param $response
     * @throws \Exception
     */
    public function terminate($request, $response)
    {
        Log::debug('test');

        // 足跡を追加
        if ($request->site != null && $request->site->approval_status == ApprovalStatus::OK) {
            if (Auth::check()) {
                // 足跡を残す設定かどうか
                if (Auth::user()->footprint == 1) {
                    Site\Footprint::add($request->site, Auth::user());
                } else {
                    Site\Footprint::add($request->site, null);
                }
            } else {
                Site\Footprint::add($request->site, null);
            }

            Site::access($request->site);
        }
    }
}

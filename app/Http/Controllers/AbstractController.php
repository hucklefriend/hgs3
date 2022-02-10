<?php
/**
 * コントローラーの基底クラス
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 不正なアクセスなどで403を出す時の共通処理
     *
     * @param array $context
     */
    protected function forbidden($context = array())
    {
        $context2 = [
            'user_id' => \Auth::id()
        ];

        Log::warning('403 forbidden', array_merge($context, $context2));
        $traces = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        foreach ($traces as $trace) {
            Log::warning('trace', $trace);
        }

        return abort(403);
    }
}

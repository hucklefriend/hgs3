<?php

namespace Hgs3\Http\Controllers\NetworkLayout;

use Hgs3\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;
use Illuminate\View\FileViewFinder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 一時的な措置
     */
    protected function setViewPath()
    {
        $app = app();
        // 読み込み元のフォルダを指定
        $paths = [base_path('resources/views2')];

        // 新しい設定を適用
        $finder = new FileViewFinder($app['files'], $paths);
        View::setFinder($finder);
    }

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

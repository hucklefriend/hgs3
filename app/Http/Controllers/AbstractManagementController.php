<?php
/**
 * 管理用のコントローラー基底クラス
 */

namespace Hgs3\Http\Controllers;

class AbstractManagementController extends Controller
{
    const ITEMS_PER_PAGE = 20;

    /**
     * 検索内容とページ番号をクエリ文字列化してセッションに保持
     *
     * @param string $key
     * @param array $search
     * @return void
     */
    protected function putSearchSession(string $key, array $search): void
    {
        $page = request()->query('page');
        if ($page !== null) {
            $search['page'] = intval($page);
        }

        if (!empty($search)) {
            session([$key => '?' . http_build_query($search)]);
        } else {
            session([$key => '']);
        }
    }
}
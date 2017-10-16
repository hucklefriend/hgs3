<?php
/**
 * レビューのステータス
 */

namespace Hgs3\Constants\Review\Injustice;

class Status
{
    const REPORTED = 0;         // 報告したのみ
    const CHECKED = 1;          // 管理人確認
    const NO_PROBLEM = 2;       // 問題なし
    const DELETED = 3;          // 削除済み
    const RETENTION = 4;        // 保留中(他に同様の報告があがれば対応)
    const IN_PROGRESS = 5;      // レビュー投稿者とやり取り中
    const WAIT_RESPONSE = 6;    // 不正報告者の返答待ち
}
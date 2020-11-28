<?php
/**
 * レビューのステータス
 */

namespace Hgs3\Constants\Review\FraudReport;

class Status
{
    const REPORTED = 0;         // 報告したのみ
    const CHECKED = 1;          // 管理人確認
    const NO_PROBLEM = 2;       // 問題なし
    const DELETED = 3;          // 削除済み
    const RETENTION = 4;        // 保留中(他に同様の報告があがれば対応)
    const IN_PROGRESS = 5;      // レビュー投稿者とやり取り中
    const WAIT_RESPONSE = 6;    // 不正報告者の返答待ち
    const SAME_REPORT = 7;      // 同じ報告があるのでそちらを見てね
    const DELETED_BY_OTHER_REPORT = 8;      // 別の報告によりレビュー削除


    public static function getText($id)
    {
        $text = '';

        switch ($id) {
            case self::REPORTED:
                $text = '報告受付';
                break;
            case self::CHECKED:
                $text = '報告を確認済み';
                break;
            case self::NO_PROBLEM:
                $text = 'レビューに問題なし';
                break;
            case self::DELETED:
                $text = 'この報告でレビューを削除';
                break;
            case self::RETENTION:
                $text = '保留中(他に同様の報告があがれば対応)';
                break;
            case self::IN_PROGRESS:
                $text = '対応中';
                break;
            case self::WAIT_RESPONSE:
                $text = '';
                break;
        }

        return $text;
    }
}
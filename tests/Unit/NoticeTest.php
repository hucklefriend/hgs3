<?php

namespace Tests\Unit;

use Tests\TestCase;
use Hgs3\Models\Orm;

class NoticeTest extends TestCase
{
    /**
     * お知らせ登録のテスト
     *
     * @return void
     */
    public function test_登録()
    {
        $nowStart = new \DateTime();
        $nowStart->sub(new \DateInterval('P1D'));
        $nowEnd = new \DateTime();
        $nowEnd->add(new \DateInterval('P1D'));
        $pastStart = new \DateTime();
        $pastStart->sub(new \DateInterval('P30D'));
        $pastEnd = new \DateTime();
        $pastEnd->sub(new \DateInterval('P20D'));
        $futureStart = new \DateTime();
        $futureStart->add(new \DateInterval('P3D'));
        $futureEnd = new \DateTime();
        $futureEnd->add(new \DateInterval('P10D'));

        $notice = new Orm\SystemNotice();
        $notice->title = '期間が現在よりも前、トップ期間も期間と同じ';
        $notice->message = 'メッセージ:期間が現在よりも前、トップ期間も期間と同じ（テスト用）';
        $notice->type = 0;
        $notice->open_at = $pastStart->format('Y-m-d H:i:s');
        $notice->close_at = $pastEnd->format('Y-m-d H:i:s');
        $notice->top_start_at = $pastStart->format('Y-m-d H:i:s');
        $notice->top_end_at = $pastEnd->format('Y-m-d H:i:s');
        $this->assertTrue($notice->save());
        $this->assertDatabaseHas('system_notices', [
            'title' => '期間が現在よりも前、トップ期間も期間と同じ',
        ]);

        $notice = new Orm\SystemNotice();
        $notice->title = '期間が未来、トップ表示期間も期間と同じ';
        $notice->message = 'メッセージ:期間が未来、トップ表示期間も期間と同じ（テスト用）';
        $notice->type = 0;
        $notice->open_at = $futureStart->format('Y-m-d H:i:s');
        $notice->close_at = $futureEnd->format('Y-m-d H:i:s');
        $notice->top_start_at = $futureStart->format('Y-m-d H:i:s');
        $notice->top_end_at = $futureEnd->format('Y-m-d H:i:s');
        $this->assertTrue($notice->save());
        $this->assertDatabaseHas('system_notices', [
            'title' => '期間が未来、トップ表示期間も期間と同じ',
        ]);

        $notice = new Orm\SystemNotice();
        $notice->title = '期間が現在かつトップ表示期間も現在';
        $notice->message = 'メッセージ:期間が現在かつトップ表示期間も現在（テスト用）';
        $notice->type = 0;
        $notice->open_at = $nowStart->format('Y-m-d H:i:s');
        $notice->close_at = $nowEnd->format('Y-m-d H:i:s');
        $notice->top_start_at = $nowStart->format('Y-m-d H:i:s');
        $notice->top_end_at = $nowEnd->format('Y-m-d H:i:s');
        $this->assertTrue($notice->save());
        $this->assertDatabaseHas('system_notices', [
            'title' => '期間が現在かつトップ表示期間も現在',
        ]);

        $notice = new Orm\SystemNotice();
        $notice->title = '期間が現在でトップ表示期間は未設定';
        $notice->message = 'メッセージ:期間が現在でトップ表示期間は未設定（テスト用）';
        $notice->type = 0;
        $notice->open_at = $nowStart->format('Y-m-d H:i:s');
        $notice->close_at = $nowEnd->format('Y-m-d H:i:s');
        $notice->top_start_at = null;
        $notice->top_end_at = null;
        $this->assertTrue($notice->save());
        $this->assertDatabaseHas('system_notices', [
            'title' => '期間が現在でトップ表示期間は未設定',
        ]);
    }

    /**
     * お知らせ編集のテスト
     */
    public function test_編集()
    {
        $notice = Orm\SystemNotice::where('title', '期間が現在でトップ表示期間は未設定')
            ->first();
        $this->assertNotNull($notice);

        $notice->message = 'メッセージ:期間が現在でトップ表示期間は未設定（テスト用）(編集)';
        $this->assertTrue($notice->save());
        $this->assertDatabaseHas('system_notices', [
            'message' => 'メッセージ:期間が現在でトップ表示期間は未設定（テスト用）(編集)',
        ]);
    }

    /**
     * お知らせトップページ一覧のテスト
     */
    public function test_トップページ取得()
    {
        $notices = Orm\SystemNotice::getTopPageData();

        $existsShown = false;
        foreach ($notices as $notice) {
            $this->assertNotEquals($notice->title, '期間が現在よりも前、トップ期間も期間と同じ');
            $this->assertNotEquals($notice->title, '期間が未来、トップ表示期間も期間と同じ');
            $this->assertNotEquals($notice->title, '期間が現在でトップ表示期間は未設定');
            if ($notice->title == '期間が現在かつトップ表示期間も現在') {
                $existsShown = true;
            }
        }

        $this->assertTrue($existsShown);
    }

    /**
     * お知らせ一覧取得のテスト
     */
    public function test_一覧取得()
    {
        $notices = Orm\SystemNotice::getNoticeIndexPageData();

        $existsShown1 = false;
        $existsShown2 = false;
        foreach ($notices as $notice) {
            $this->assertNotEquals($notice->title, '期間が現在よりも前、トップ期間も期間と同じ');
            $this->assertNotEquals($notice->title, '期間が未来、トップ表示期間も期間と同じ');
            if ($notice->title == '期間が現在かつトップ表示期間も現在') {
                $existsShown1 = true;
            } else if ($notice->title == '期間が現在でトップ表示期間は未設定') {
                $existsShown2 = true;
            }
        }

        $this->assertTrue($existsShown1);
        $this->assertTrue($existsShown2);
    }

    /**
     * お知らせ削除のテスト
     */
    public function test_削除()
    {
        $notices = Orm\SystemNotice::where('message', 'LIKE', '%（テスト用）%')->get();
        foreach ($notices as $notice) {
            $notice->delete();
            $this->assertDeleted($notice);
            break;
        }
    }
}

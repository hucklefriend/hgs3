<?php

namespace Tests\Feature\Management\Master;

use Hgs3\Models\Orm\GameHard;
use Tests\Feature\Management\ManagementBase;

class HardTest extends ManagementBase
{
    /**
     * ハードのテスト
     *
     * @group hard
     * @return void
     */
    public function test_ハード(): void
    {
        $user = $this->getManagerAccount();

        // ハード一覧が表示される
        $response = $this->actingAs($user)->get(route('管理-マスター-ハード'));
        $response->assertStatus(200);

        // 新規登録画面の表示
        $response = $this->actingAs($user)->get(route('管理-マスター-ハード登録'));
        $response->assertStatus(200);

        // 新規登録
        $response = $this->actingAs($user)->post(
            route('管理-マスター-ハード'),
            [
                'name' => 'テストハード',
                'phonetic' => 'てすとはーど',
                'acronym' => 'TH',
                'sort_order' => '9999',
                'maker_id' => 1
            ]
        );
        $response->assertStatus(200);

        // DBにある
        $this->assertDatabaseHas('game_hards', [
            'name' => 'テストハード',
        ]);

        // 新規登録した結果がハード一覧にある
        $response = $this->actingAs($user)->get(route('管理-マスター-ハード'));
        $response->assertStatus(200)
            ->assertSeeText('テストハード');

        // DBから取得(IDが最大のやつのはず）
        $hard = GameHard::orderBy('id', 'desc')
            ->limit(1)
            ->first();

        // 詳細に遷移できる
        $response = $this->actingAs($user)->get(route('管理-マスター-ハード詳細', $hard));
        $response->assertStatus(200)
            ->assertSeeText('テストハード');

        // 編集に遷移できる
        $response = $this->actingAs($user)->get(route('管理-マスター-ハード詳細', $hard));
        $response->assertStatus(200)
            ->assertSeeText('テストハード');

        // 編集できる
        $response = $this->actingAs($user)->put(
            route('管理-マスター-ハード編集'),
            [
                'name' => 'テストハード（編集）',
                'phonetic' => 'てすとはーど（編集）',
                'acronym' => 'THE',
                'sort_order' => '99999999',
                'maker_id' => 1
            ]
        );
        $response->assertStatus(200);

        // 編集されている
        $hard->refresh();

        // 詳細画面で編集されていることを確認
        $response = $this->actingAs($user)->get(route('管理-マスター-ハード詳細', $hard));
        $response->assertStatus(200)
            ->assertSeeText('テストハード（編集）')
            ->assertSeeText('てすとはーど（編集）')
            ->assertSeeText('THE')
            ->assertSeeText('99999999');

        // 削除できる
        $response = $this->actingAs($user)->delete(route('管理-マスター-ハード削除', $hard));
        $response->assertStatus(200);

        // DBから消えている
        $this->assertDatabaseMissing('game_hards', [
            'name' => 'テストハード（編集）',
        ]);
    }
}

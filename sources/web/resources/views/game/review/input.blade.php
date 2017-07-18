@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}のレビュー投稿</h4>

    <nav style="margin-bottom: 20px;">
        <a href="{{ url('game/review/soft') }}/{{ $game->id }}">戻る</a>
    </nav>

    <form method="POST" action="{{ url('game/review/input') }}">
        {{ csrf_field() }}
        <input type="hidden" name="game_id" value="{{ $game->id }}">

        <div class="form-group">
            <label for="title">一言</label>
            <input type="text" name="title" class="form-control" value="{{ $review->title }}">
        </div>

        <div class="form-group">

            <label for="play_time">プレイ時間</label>
            <div class="form-inline">
                <input type="number" min="0" max="255" id="play_time" name="play_time" class="form-control" value="{{ $review->play_time }}">&nbsp;時間
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">怖さ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear1" value="1" @if ($review->fear == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear2" value="2" @if ($review->fear == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear3" value="3" @if ($review->fear == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear4" value="4" @if ($review->fear == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear5" value="5" @if ($review->fear == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">シナリオ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story1" value="1" @if ($review->story == 1) checked @endif> 1
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story2" value="2" @if ($review->story == 2) checked @endif> 2
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story3" value="3" @if ($review->story == 3) checked @endif> 3
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story4" value="4" @if ($review->story == 4) checked @endif> 4
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story5" value="5" @if ($review->story == 5) checked @endif> 5
                </label>
            </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">ボリューム</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume1" value="1" @if ($review->volume == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume2" value="2" @if ($review->volume == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume3" value="3" @if ($review->volume == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume4" value="4" @if ($review->volume == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume5" value="5" @if ($review->volume == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">グラフィック</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic1" value="1" @if ($review->graphic == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic2" value="2" @if ($review->graphic == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic3" value="3" @if ($review->graphic == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic4" value="4" @if ($review->graphic == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic5" value="5" @if ($review->graphic == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">サウンド</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound1" value="1" @if ($review->sound == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound2" value="2" @if ($review->sound == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound3" value="3" @if ($review->sound == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound4" value="4" @if ($review->sound == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound5" value="5" @if ($review->sound == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">操作性</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability1" value="1" @if ($review->controllability == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability2" value="2" @if ($review->controllability == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability3" value="3" @if ($review->controllability == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability4" value="4" @if ($review->controllability == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability5" value="5" @if ($review->controllability == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">難易度</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty1" value="1" @if ($review->difficulty == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty2" value="2" @if ($review->difficulty == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty3" value="3" @if ($review->difficulty == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty4" value="4" @if ($review->difficulty == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty5" value="5" @if ($review->difficulty == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">やりこみ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded1" value="1" @if ($review->crowded == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded2" value="2" @if ($review->crowded == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded3" value="3" @if ($review->crowded == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded4" value="4" @if ($review->crowded == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded5" value="5" @if ($review->crowded == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">オススメ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend1" value="1" @if ($review->crowded == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend2" value="2" @if ($review->crowded == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend3" value="3" @if ($review->crowded == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend4" value="4" @if ($review->crowded == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend5" value="5" @if ($review->crowded == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="thoughts">感想</label>
            <textarea name="thoughts" id="thoughts" class="form-control">{{ $review->thoughts }}</textarea>
            <p class="help-block">プレイした感想、どこが良かったか、どこが悪かった、あのシーンがすごく良い、もっとこうしてくれたらなど、ネタバレもありで自由に記入ください</p>
        </div>

        <div class="form-group">
            <label for="recommendatory">オススメ</label>
            <textarea name="recommendatory" id="recommendatory" class="form-control">{{ $review->recommendatory }}</textarea>
            <p class="help-block">未プレイユーザーへネタバレ無しでオススメ文を記入ください。</p>
        </div>

        <div class="form-group">
            <button class="btn btn-info" name="draft" value="1">下書き保存</button>
            <button class="btn btn-primary" style="margin-left: 30px;" name="draft" value="0">確認</button>
        </div>
    </form>
@endsection

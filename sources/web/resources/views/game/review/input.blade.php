@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}のレビュー投稿</h4>

    <nav style="margin-bottom: 20px;">
        <a href="{{ url('game/review/soft') }}/{{ $game->id }}">戻る</a>
    </nav>

    <form method="POST" action="{{ url('game/review/confirm') }}/{{ $game->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="game_id" value="{{ $game->id }}">

        @if (count($packages) > 1)
        <div>
            <p class="help-block">
                レビューを書くパッケージを選択してください。
            </p>

            <div class="form-group">
                @foreach ($packages as $pkg)
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" value="{{ $pkg->id }}" name="package_id" @if ($pkg->id == $draft->package_id) checked @endif>
                        <img src="{{ $pkg->small_image_url }}" class="thumbnail"><br>
                        {{ $pkg->acronym }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @elseif (!empty($packages))
            <input type="hidden" name="package_id" value="{{ $packages[0]->id }}">
        @endif

        <div class="form-group">
            <label for="title">一言</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $draft->title }}">
        </div>

        <div class="form-group">

            <label for="play_time">プレイ時間</label>
            <div class="form-inline">
                <input type="number" min="0" max="255" id="play_time" name="play_time" class="form-control" value="{{ $draft->play_time }}">&nbsp;時間
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">怖さ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear1" value="1" @if ($draft->fear == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear2" value="2" @if ($draft->fear == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear3" value="3" @if ($draft->fear == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear4" value="4" @if ($draft->fear == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="fear" id="fear5" value="5" @if ($draft->fear == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">シナリオ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story1" value="1" @if ($draft->story == 1) checked @endif> 1
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story2" value="2" @if ($draft->story == 2) checked @endif> 2
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story3" value="3" @if ($draft->story == 3) checked @endif> 3
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story4" value="4" @if ($draft->story == 4) checked @endif> 4
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="story" id="story5" value="5" @if ($draft->story == 5) checked @endif> 5
                </label>
            </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">ボリューム</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume1" value="1" @if ($draft->volume == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume2" value="2" @if ($draft->volume == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume3" value="3" @if ($draft->volume == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume4" value="4" @if ($draft->volume == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="volume" id="volume5" value="5" @if ($draft->volume == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">グラフィック</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic1" value="1" @if ($draft->graphic == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic2" value="2" @if ($draft->graphic == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic3" value="3" @if ($draft->graphic == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic4" value="4" @if ($draft->graphic == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="graphic" id="graphic5" value="5" @if ($draft->graphic == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">サウンド</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound1" value="1" @if ($draft->sound == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound2" value="2" @if ($draft->sound == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound3" value="3" @if ($draft->sound == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound4" value="4" @if ($draft->sound == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="sound" id="sound5" value="5" @if ($draft->sound == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">操作性</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability1" value="1" @if ($draft->controllability == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability2" value="2" @if ($draft->controllability == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability3" value="3" @if ($draft->controllability == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability4" value="4" @if ($draft->controllability == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="controllability" id="controllability5" value="5" @if ($draft->controllability == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">難易度</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty1" value="1" @if ($draft->difficulty == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty2" value="2" @if ($draft->difficulty == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty3" value="3" @if ($draft->difficulty == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty4" value="4" @if ($draft->difficulty == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="difficulty" id="difficulty5" value="5" @if ($draft->difficulty == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">やりこみ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded1" value="1" @if ($draft->crowded == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded2" value="2" @if ($draft->crowded == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded3" value="3" @if ($draft->crowded == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded4" value="4" @if ($draft->crowded == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="crowded" id="crowded5" value="5" @if ($draft->crowded == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">オススメ</label>
            <div class="col-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend1" value="1" @if ($draft->recommend == 1) checked @endif> 1
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend2" value="2" @if ($draft->recommend == 2) checked @endif> 2
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend3" value="3" @if ($draft->recommend == 3) checked @endif> 3
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend4" value="4" @if ($draft->recommend == 4) checked @endif> 4
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="recommend" id="recommend5" value="5" @if ($draft->recommend == 5) checked @endif> 5
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="thoughts">感想</label>
            <textarea name="thoughts" id="thoughts" class="form-control">{{ $draft->thoughts }}</textarea>
            <p class="help-block">プレイした感想、どこが良かったか、どこが悪かった、あのシーンがすごく良い、もっとこうしてくれたらなど、ネタバレもありで自由に記入ください</p>
        </div>

        <div class="form-group">
            <label for="recommendatory">オススメ</label>
            <textarea name="recommendatory" id="recommendatory" class="form-control">{{ $draft->recommendatory }}</textarea>
            <p class="help-block">未プレイユーザーへネタバレ無しでオススメ文を記入ください。</p>
        </div>

        <div class="form-group">
            <button class="btn btn-primary">確認</button>
        </div>
    </form>
@endsection

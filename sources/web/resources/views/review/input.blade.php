@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-stretch">
        <div class="align-self-top p-2">
            @include ('game.common.package_image', ['imageUrl' => $package->small_image_url])
        </div>
        <div class="align-self-top">
            <div>
                <h4>{{ $package->name }}のレビューを書く</h4>
            </div>
            <div>
                <a href="{{ url2('review/package_select') }}/{{ $package->game_id }}">パッケージを選び直す</a>
            </div>
        </div>
    </div>

    <hr>

    <form method="POST" action="{{ url2('review/confirm') }}/{{ $package->id }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">一言(タイトル)</label>
            <input type="text" name="title" id="title" class="form-control{{ invalid($errors, 'title') }}" value="{{ $draft->title }}" maxlength="100" required>
            @include('common.error', ['formName' => 'title'])
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
            <label for="progress">ゲームのプレイ状況</label>
            <textarea name="progress" id="progress" class="form-control{{ invalid($errors, 'progress') }}" maxlength="300" required>{{ $draft->progress }}</textarea>
            @include('common.error', ['formName' => 'progress'])
            <small class="form-text text-muted">
                「5周クリア」「XXルートだけクリア」など、どの程度遊んだ上でレビューを書くのか記載してください。
            </small>
        </div>

        <div class="form-group">
            <label for="text">レビュー</label>
            <textarea name="text" id="text" class="form-control{{ invalid($errors, 'text') }}" maxlength="10000" required>{{ $draft->text }}</textarea>
            @include('common.error', ['formName' => 'text'])
            <small class="form-text text-muted">
                書き方は自由です！<br>
                良かった点や悪かった点など、思う所を書いていってください。<br>
                <strong><span class="text-danger">ネタバレがある場合は、必ず↓にチェックを入れてください。</span></strong>
            </small>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="is_spoiler"{{ checked(1, $draft->is_spoiler) }} value="1">
                ネタバレあり
            </label>
        </div>

        <br>

        <div class="form-group">
            <button class="btn btn-primary btn-block">確認</button>
        </div>
    </form>

    <script>
        $(function (){
            $('.package_check').on('click', function(){
                $('.package_select_item.selected').removeClass('selected');


                $(this).parents('.package_select_item').addClass('selected');
            });
        });
    </script>


@endsection

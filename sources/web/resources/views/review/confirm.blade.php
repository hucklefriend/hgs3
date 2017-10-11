@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}のレビュー投稿 確認</h4>

    <form method="POST" action="{{ url('game/review/save') }}/{{ $game->id }}">
        {{ csrf_field() }}

        <input type="hidden" name="game_id" value="{{ $draft->game_id }}">
        <input type="hidden" name="package_id" value="{{ $draft->package_id }}">
        <input type="hidden" name="title" value="{{ $draft->title }}">
        <input type="hidden" name="play_time" value="{{ $draft->play_time }}">
        <input type="hidden" name="fear" value="{{ $draft->fear }}">
        <input type="hidden" name="story" value="{{ $draft->story }}">
        <input type="hidden" name="volume" value="{{ $draft->volume }}">
        <input type="hidden" name="difficulty" value="{{ $draft->difficulty }}">
        <input type="hidden" name="graphic" value="{{ $draft->graphic }}">
        <input type="hidden" name="sound" value="{{ $draft->sound }}">
        <input type="hidden" name="crowded" value="{{ $draft->crowded }}">
        <input type="hidden" name="controllability" value="{{ $draft->controllability }}">
        <input type="hidden" name="recommend" value="{{ $draft->recommend }}">
        <input type="hidden" name="thoughts" value="{{ $draft->thoughts }}">
        <input type="hidden" name="recommendatory" value="{{ $draft->recommendatory }}">

        <div>
            <p>{{ $draft->title }}</p>
        </div>
        <div class="row">
            <div class="col-2">怖さ</div>
            <div class="col-2">{{ $draft->fear }}</div>
            <div class="col-2">シナリオ</div>
            <div class="col-2">{{ $draft->story }}</div>
            <div class="col-2">ボリューム</div>
            <div class="col-2">{{ $draft->volume }}</div>
        </div>
        <div class="row">
            <div class="col-2">グラフィック</div>
            <div class="col-2">{{ $draft->graphic }}</div>
            <div class="col-2">サウンド</div>
            <div class="col-2">{{ $draft->sound }}</div>
            <div class="col-2">操作性</div>
            <div class="col-2">{{ $draft->controllability }}</div>
        </div>
        <div class="row">
            <div class="col-2">難易度</div>
            <div class="col-2">{{ $draft->difficulty }}</div>
            <div class="col-2">やりこみ</div>
            <div class="col-2">{{ $draft->crowded }}</div>
            <div class="col-2">オススメ</div>
            <div class="col-2">{{ $draft->recommend }}</div>
        </div>

        <div>感想</div>
        <pre>{{ $draft->thoughts }}</pre>

        <div>おすすめ</div>
        <pre>{{ $draft->recommendatory }}</pre>
        <div class="form-group">
            <button class="btn btn-default" name="draft" value="-1">入力画面に戻る</button>
            <button class="btn btn-warning" style="margin-left: 30px;" name="draft" value="1">下書き保存</button>
            <button class="btn btn-primary" style="margin-left: 30px;" name="draft" value="0">保存</button>
        </div>
    </form>
@endsection

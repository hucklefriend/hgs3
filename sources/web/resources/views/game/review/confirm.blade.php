@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}のレビュー投稿 確認</h4>

    <form method="POST" action="{{ url('game/review/save/') }}/{{ $game->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="game_id" value="{{ old('game_id') }}">
        <input type="hidden" name="title" value="{{ old('title') }}">
        <input type="hidden" name="play_time" value="{{ old('play_time') }}">
        <input type="hidden" name="fear" value="{{ old('fear') }}">
        <input type="hidden" name="story" value="{{ old('story') }}">
        <input type="hidden" name="volume" value="{{ old('volume') }}">
        <input type="hidden" name="difficulty" value="{{ old('difficulty') }}">
        <input type="hidden" name="graphic" value="{{ old('graphic') }}">
        <input type="hidden" name="sound" value="{{ old('sound') }}">
        <input type="hidden" name="crowded" value="{{ old('crowded') }}">
        <input type="hidden" name="controllability" value="{{ old('controllability') }}">
        <input type="hidden" name="recommend" value="{{ old('recommend') }}">
        <input type="hidden" name="thoughts" value="{{ old('thoughts') }}">
        <input type="hidden" name="recommendatory" value="{{ old('recommendatory') }}">

        <div>
            <p>{{ old('title') }}</p>
        </div>
        <div class="row">
            <div class="col-2">怖さ</div>
            <div class="col-2">{{ old('fear') }}</div>
            <div class="col-2">シナリオ</div>
            <div class="col-2">{{ old('story') }}</div>
            <div class="col-2">ボリューム</div>
            <div class="col-2">{{ old('volume') }}</div>
        </div>
        <div class="row">
            <div class="col-2">グラフィック</div>
            <div class="col-2">{{ old('graphic') }}</div>
            <div class="col-2">サウンド</div>
            <div class="col-2">{{ old('sound') }}</div>
            <div class="col-2">操作性</div>
            <div class="col-2">{{ old('controllability') }}</div>
        </div>
        <div class="row">
            <div class="col-2">難易度</div>
            <div class="col-2">{{ old('difficulty') }}</div>
            <div class="col-2">やりこみ</div>
            <div class="col-2">{{ old('crowded') }}</div>
            <div class="col-2">オススメ</div>
            <div class="col-2">{{ old('recommend') }}</div>
        </div>

        <div>感想</div>
        <pre>{{ old('thoughts') }}</pre>

        <div>おすすめ</div>
        <pre>{{ old('recommendatory') }}</pre>

        <div class="form-group">
            <button class="btn btn-info" name="draft" value="1">下書き保存</button>
            <button class="btn btn-primary" style="margin-left: 30px;" name="draft" value="0">保存</button>
        </div>
    </form>
@endsection

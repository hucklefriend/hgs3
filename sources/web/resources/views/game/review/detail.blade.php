@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}</h4>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/soft') }}/{{ $game->id }}">詳細へ</a> |
        <a href="{{ url('game/review/soft') }}/{{ $game->id }}">他のレビュー</a> |
        <a href="{{ url('game/review') }}"></a>
    </nav>

    <section>
        <div class="row">
            <div class="col-1">{{ $review->point }}</div>
            <div class="col-11"><h5>{{ $review->title }}</h5></div>
        </div>
        <div>
            <div class="row">
                <div class="col-2">怖さ</div>
                <div class="col-2">{{ $review->fear }}</div>
                <div class="col-2">シナリオ</div>
                <div class="col-2">{{ $review->story }}</div>
                <div class="col-2">ボリューム</div>
                <div class="col-2">{{ $review->volume }}</div>
            </div>
            <div class="row">
                <div class="col-2">グラフィック</div>
                <div class="col-2">{{ $review->graphic }}</div>
                <div class="col-2">サウンド</div>
                <div class="col-2">{{ $review->sound }}</div>
                <div class="col-2">操作性</div>
                <div class="col-2">{{ $review->controllability }}</div>
            </div>
            <div class="row">
                <div class="col-2">難易度</div>
                <div class="col-2">{{ $review->difficulty }}</div>
                <div class="col-2">やりこみ</div>
                <div class="col-2">{{ $review->crowded }}</div>
                <div class="col-2">オススメ</div>
                <div class="col-2">{{ $review->recommend }}</div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}</h4>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/soft') }}/{{ $game->id }}">詳細へ</a>|
        <a href="{{ url('game/review/input') }}/{{ $game->id }}">投稿する</a>
    </nav>

    <section>
        <h5>累計</h5>
        <div>
            @if ($total != null)
                <div class="row">
                    <div class="col-2">平均ポイント</div>
                    <div class="col-2">{{ $total->point }}</div>
                    <div class="col-2">平均プレイ時間</div>
                    <div class="col-2">{{ $total->play_time }}</div>
                    <div class="col-2">レビュー数</div>
                    <div class="col-2">{{ $total->review_num }}</div>
                </div>
                <div class="row">
                    <div class="col-2">怖さ</div>
                    <div class="col-2">{{ $total->fear }}</div>
                    <div class="col-2">シナリオ</div>
                    <div class="col-2">{{ $total->story }}</div>
                    <div class="col-2">ボリューム</div>
                    <div class="col-2">{{ $total->volume }}</div>
                </div>
                <div class="row">
                    <div class="col-2">グラフィック</div>
                    <div class="col-2">{{ $total->graphic }}</div>
                    <div class="col-2">サウンド</div>
                    <div class="col-2">{{ $total->sound }}</div>
                    <div class="col-2">操作性</div>
                    <div class="col-2">{{ $total->controllability }}</div>
                </div>
                <div class="row">
                    <div class="col-2">難易度</div>
                    <div class="col-2">{{ $total->difficulty }}</div>
                    <div class="col-2">やりこみ</div>
                    <div class="col-2">{{ $total->crowded }}</div>
                    <div class="col-2">オススメ</div>
                    <div class="col-2">{{ $total->recommend }}</div>
                </div>
            @else
                レビューは投稿されていません
            @endif
        </div>
    </section>

    <section style="margin-top: 30px;">
        @foreach ($reviews as $r)
            <div class="row">
                <div class="col-1 text-center" style="font-size: 30px;">{{ $r->point }}</div>
                <div class="col-11">
                    <h5><a href="{{ url('game/review/detail') }}/{{ $r->id }}">{{ $r->title }}</a></h5>
                    <div>{{ $r->user_name }} {{ $r->post_date }}</div>
                </div>
            </div>
            <hr>
        @endforeach
    </section>

    <div>
        <a href="{{ url('game/review/soft') }}/{{ $game->id }}">レビュー一覧へ</a>
    </div>
@endsection
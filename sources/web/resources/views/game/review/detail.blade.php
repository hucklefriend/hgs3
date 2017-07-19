@extends('layouts.app')

@section('content')

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/soft') }}/{{ $game->id }}">詳細へ</a> |
        <a href="{{ url('game/review/soft') }}/{{ $game->id }}">他のレビュー</a> |
        <a href="{{ url('game/review') }}"></a>
    </nav>

    <section>
        <div class="row">
            <div class="col-1 text-center">
                <img src="{{ $pkg->small_image_url }}" class="thumbnail"><br>
                {{ $pkg->name }}
            </div>
            <div class="col-1">{{ $review->point }}</div>
            <div class="col-10"><h5>{{ $review->title }}</h5></div>
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
        <div>
            <h5>感想</h5>
            <pre>{{ $review->thoughts }}</pre>
            <h5>おすすめ</h5>
            <pre>{{ $review->recommendatory }}</pre>
        </div>
        <div>
            @if ($hasGood)
                <form action="{{ url('game/review/cancel_good') }}/{{ $review->id }}">

                    <button>いいね取り消し</button>
                </form>
            @else
                <form action="{{ url('game/review/good') }}/{{ $review->id }}">
                    <button>いいね</button>
                </form>
            @endif
        </div>
        <div class="row">
            <div class="col-2">いいね数</div>
            <div class="col-2">{{ $review->good_num }}</div>
            <div class="col-8"><a href="{{ url('game/review/good_history') }}/{{ $review->id }}">いいねした人たち</a></div>
        </div>
        <div class="row">
            <div class="col-2">直近30日のいいね数</div>
            <div class="col-2">{{ $review->latest_good_num }}</div>
        </div>
    </section>
@endsection
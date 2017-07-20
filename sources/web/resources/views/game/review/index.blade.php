@extends('layouts.app')

@section('content')

    <section>
        <h4>新着</h4>
        @if (empty($newArrival))
            <p>新着レビューはありません。</p>
        @else
            <div>
                @foreach ($newArrival as $r)
                    <div class="row">
                        <div class="col-1">
                            <img src="{{ $r->small_image_url }}" class="thumbnail"><br>
                            {{ $r->game_name }}
                        </div>
                        <div class="col-1">{{ $r->point }}</div>
                        <div class="col-10">
                            <p><a href="{{ url('game/review/detail/') }}/{{ $r->id }}">{{ $r->title }}</a></p>
                            <p>{{ $r->user_name }} {{ $r->post_date }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <hr>

    <section>
        <h4>高評価</h4>
        @if (empty($highScore))
            <p>高評価ゲームはありません。</p>
        @else
            <div>
                @foreach ($highScore as $r)
                    <div class="row">
                        <div class="col-1">
                            <a href="{{ url('game/review/soft') }}/{{ $r->game_id }}">
                                <img src="{{ $r->small_image_url }}" class="thumbnail"><br>
                                {{ $r->game_name }}
                            </a>
                        </div>
                        <div class="col-1">{{ $r->point }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <hr>

    <section>
        <h4>いいね(直近1ヶ月)</h4>
        @if (empty($manyGood))
            <p>いいね(直近1ヶ月)が多いレビューはありません。</p>
        @else
            <div>
                @foreach ($manyGood as $r)
                    <div class="row">
                        <div class="col-1">
                            <img src="{{ $r->small_image_url }}" class="thumbnail"><br>
                            {{ $r->game_name }}
                        </div>
                        <div class="col-1">{{ $r->point }}</div>
                        <div class="col-10">
                            <p><a href="{{ url('game/review/detail/') }}/{{ $r->id }}">{{ $r->title }}</a></p>
                            <p>{{ $r->user_name }} {{ $r->post_date }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

@endsection
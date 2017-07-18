@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}</h4>

    <nav>
        <a href="{{ url('game/soft') }}">一覧へ</a>
    </nav>

    <section>
        <div class="row">
            <div class="col-3">メーカー</div>
            <div class="col-8">
                @if($company != null)
                    <a href="{{ url('game/company') }}/{{ $company->id }}">{{ $company->name }}</a>
                @endif
            </div>
        </div>
        <p><a href="{{ url('game/soft/edit') }}/{{ $game->id }}">データ編集</a></p>
    </section>


    <section>
        <h5>コメント</h5>
        <div>
            @foreach ($comments as $comment)
                <div>
                    <p>{{ $comment->user_name }} says 「{{ $comment->comment }}」</p>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ url('game/soft/comment') }}/{{ $game->id }}">
            {{ csrf_field() }}
            <textarea class="form-control" name="comment"></textarea>
            <button class="btn btn-default" type="submit">投稿</button>
        </form>
    </section>

    <section>
        <h5>レビュー</h5>
        <div>
            @if ($review != null)
            <div class="row">
                <div class="col-2">平均ポイント</div>
                <div class="col-2">{{ $review->point }}</div>
                <div class="col-2">平均プレイ時間</div>
                <div class="col-2">{{ $review->play_time }}</div>
                <div class="col-2">レビュー数</div>
                <div class="col-2">{{ $review->review_num }}</div>
            </div>
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
            @else
                レビューは投稿されていません
            @endif
        </div>
        <div>
            <a href="{{ url('game/review/soft') }}/{{ $game->id }}">レビュー一覧へ</a>
        </div>
    </section>

    <section>
        <h5>パッケージ</h5>
        @foreach ($packages as $pkg)
        <div class="row">
            <div class="col-2">
                <img src="{{ $pkg->medium_image_url }}" class="thumbnail" style="max-width: 100%;">
            </div>
            <div class="col-8">
                <div>{{ $pkg->name }}</div>
                <div>{{ $pkg->platform_name }}</div>
                <div>{{ $pkg->release_date }}</div>
                <div>
                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                </div>
                <div style="margin-top: 15px;">
                    <a href="{{ url('game/package/edit') }}/{{ $game->id }}/{{ $pkg->id }}"><button type="button" class="btn btn-info">編集</button></a>
                    <form method="POST" action="{{ url('game/package/delete') }}/{{ $pkg->id }}">
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        <p><a href="{{ url('game/package/add') }}/{{ $game->id }}">パッケージを追加</a></p>
    </section>

@if($series != null)
    <section>
        <h5>{{ $series['name'] }}シリーズの別タイトル</h5>
        <ul class="list-group">
            @foreach ($series['list'] as $sl)
            <li class="list-group-item">
                <a href="{{ url('game/soft') }}/{{ $sl->id }}">{{ $sl->name }}</a>
            </li>
            @endforeach
        </ul>
    </section>
@endif

<style>
    section {
        margin-top: 30px;
    }
</style>

@endsection
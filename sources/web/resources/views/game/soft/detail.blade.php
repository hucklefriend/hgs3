@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ $soft['name'] }}</h4>

        <nav>
            <a href="{{ url('game/soft') }}">一覧へ</a>
        </nav>

        <section>
            <div class="row">
                <div class="col-3">メーカー</div>
                <div class="col-8">
                    @if($soft['company'] != null)
                        <a href="{{ url('game/company') }}/{{ $soft['company']->id }}">{{ $soft['company']->name }}</a>
                    @endif
                </div>
            </div>
            <p><a href="{{ url('game/soft/edit') }}/{{ $soft['id'] }}">データ編集</a></p>
        </section>


        <section>
            <h5>コメント</h5>
            <div>
                @foreach ($soft['comments'] as $comment)
                    <div>
                        <p>{{ $comment->user_name }} says 「{{ $comment->comment }}」</p>
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ url('game/soft/comment') }}/{{ $soft['id'] }}">
                {{ csrf_field() }}
                <textarea class="form-control" name="comment"></textarea>
                <button class="btn btn-default" type="submit">投稿</button>
            </form>
        </section>

        <section>
            <h5>パッケージ</h5>
            @foreach ($soft['packages'] as $pkg)
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
                        <a href="#"><button type="button" class="btn btn-info">編集</button></a>
                        <a href="#" style="margin-left: 30px;"><button type="button" class="btn btn-danger">削除</button></a>
                    </div>
                </div>
            </div>
            @endforeach
            <p><a href="{{ url('game/soft/package/add') }}/{{ $soft['id'] }}">パッケージを追加</a></p>
        </section>

        @if($soft['series'] != null)
            <section>
                <h5>{{ $soft['series']['name'] }}シリーズの別タイトル</h5>
                <ul class="list-group">
                    @foreach ($soft['series']['list'] as $sl)
                    <li class="list-group-item">
                        <a href="{{ url('game/soft') }}/{{$sl->id}}">{{ $sl->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>

    <style>
        section {
            margin-top: 30px;
        }
    </style>

@endsection
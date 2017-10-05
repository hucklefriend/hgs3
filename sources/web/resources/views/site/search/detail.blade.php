@extends('layouts.app')

@section('content')

    <nav>
        <a href="{{ url('site/search') }}">サイト一覧</a>
    </nav>

    <hr>

    <div class="card">
        <div class="card-body">
            <h4>{{ $site->name }}</h4>
            <div class="row">
                <div class="col-2">URL</div>
                <div class="col-10"><a href="{{ url('/site/go') }}/{{ $site->id }}">{{ $site->url }}</a></div>
            </div>
            <div class="row">
                <div class="col-2">管理人</div>
                <div class="col-10">{{ $admin->name }}さん</div>
            </div>
            <div class="row">
                <div class="col-2">取扱いゲーム</div>
                <div class="col-10">{{ $handleGames }}</div>
            </div>
            <div class="row">
                <div class="col-2">メインコンテンツ</div>
                <div class="col-10">{{ $site->main_contents_id }}</div>
            </div>
            <div class="row">
                <div class="col-2">対象年齢</div>
                <div class="col-10">{{ $site->rate }}</div>
            </div>
            <div class="row">
                <div class="col-2">性別傾向</div>
                <div class="col-10">{{ $site->gender }}</div>
            </div>
            <div class="row">
                <div class="col-2">紹介文</div>
                <div class="col-10"><pre>{{ $site->presentation }}</pre></div>
            </div>
            <div class="row">
                <div class="col-2">OUTカウント</div>
                <div class="col-10">{{ $site->out_count }}</div>
            </div>
            <div class="row">
                <div class="col-2">INカウント</div>
                <div class="col-10">{{ $site->in_count }}</div>
            </div>
            <div class="row">
                <div class="col-2">お気に入り</div>
                <div class="col-10">
                    @if ($isFavorite)
                        登録済み
                        <form method="POST" action="{{ url('user/favorite_site') }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <button class="btn btn-primary">解除する</button>
                        </form>
                    @else
                        <form method="POST" action="{{ url('user/favorite_site') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <button class="btn btn-primary">登録する</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5>お気に入り登録者</h5>
                    @foreach ($favoriteUsers as $fu)
                        <hr>
                        <a href="{{ url('user/profile') }}/{{ $fu->user_id }}">{{ $users[$fu->user_id] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5>足跡</h5>
                    @foreach ($footprint as $fp)
                        <div class="row">
                            <div class="col-4">{{ $fp->user_id }}</div>
                            <div class="col-8"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
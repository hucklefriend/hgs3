@extends('layouts.app')

@section('title')サイト登録@endsection
@section('global_back_link'){{ route('サイト管理') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト登録</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">H.G.S.から引き継ぎ。</h4>

                <p>
                    引き継ぐサイトを選択してください。<br>
                    何回でも引き継いで登録できるようになっているのですが、同じサイトを複数登録しないようお願いします。
                </p>
                <ul class="list-group">
                    @foreach ($hgs2Sites as $hgs2Site)
                        <li class="list-group-item">
                            <a href="{{ route('サイト引継登録', ['hgs2SiteId' => $hgs2Site->id]) }}">{{ $hgs2Site->site_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト管理') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">H.G.S.から引き継ぎ</li>
        </ol>
    </nav>
@endsection
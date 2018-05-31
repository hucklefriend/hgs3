@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー@endsection
@section('global_back_link'){{ route('ソフト別レビュー一覧', ['soft' => $soft->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1 class="mb-2">{{ $soft->name }}</h1>
            <p class="mb-0"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">{{ $user->name }}さん</a>のレビュー</p>
            <p class="mb-0">{{ format_date(strtotime($review->post_at)) }} 投稿</p>
        </header>

        @include('review.common.show', ['review' => $review])

        @if (!$isWriter)
        <div class="row">
            <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                <div class="card card-hgn">
                    <div class="card-body">
                        @if ($impression == 0)
                        <p>レビューを読んで、印象はいかがでしたか？</p>
                        @elseif ($impression == 1)
                            <p>
                                🤔で印象を投稿済みです。<br>
                                印象の変更や取り消しを、↓のボタンで行えます。
                            </p>
                        @elseif ($impression == 2)
                            <p>
                                😒で印象を投稿済みです。<br>
                                印象の変更や取り消しを、↓のボタンで行えます。
                            </p>
                        @endif
                        @auth
                            <div class="row">
                                @if ($impression != 1)
                                <form method="POST" action="{{ route('ふむふむ', ['review' => $review->id]) }}" class="col-6">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-light btn-block">🤔 ふむふむ</button>
                                </form>
                                @endif
                                @if ($impression != 2)
                                <form method="POST" action="{{ route('んー…', ['review' => $review->id]) }}" class="col-6">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-light btn-block">😒 んー…</button>
                                </form>
                                @endif
                                @if ($impression != 0)
                                <form method="POST" action="{{ route('レビュー印象取り消し', ['review' => $review->id]) }}" class="col-6">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-light btn-block">取り消し</button>
                                </form>
                                @endif
                            </div>
                        @else
                            <p>印象を投稿するにはログインしてください。</p>
                            <div class="text-right mt-2">
                                <a href="{{ route('ログイン') }}" class="badge badge-pill and-more">ログイン</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
            @endif
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイトマップ</li>
        </ol>
    </nav>
@endsection

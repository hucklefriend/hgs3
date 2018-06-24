@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::review($review) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1 class="mb-2">{{ $soft->name }}</h1>
            <div class="d-flex flex-wrap">
                <p class="mb-0 mr-4"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">{{ $user->name }}さん</a>のレビュー</p>
                <p class="mb-0 mr-4">{{ format_date(strtotime($review->post_at)) }} 投稿</p>
                <p class="mb-0 mr-4">👀 {{ number_format($review->access_count) }}</p>
                <p class="mb-0 mr-4">🤔 {{ $review->fmfm_num }}</p>
                <p class="mb-0 mr-4">😒 {{ $review->n_num }}</p>
            </div>
        </header>

        @include('review.common.show', ['review' => $review])

        @if (!$isWriter)
        <div class="row">
            <div class="col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7">
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
                                <form method="POST" action="{{ route('ふむふむ', ['review' => $review->id]) }}" class="col-5 mb-3">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-light btn-block">🤔<span class="hidden-xs-down"> ふむふむ</span></button>
                                </form>
                                @endif
                                @if ($impression != 2)
                                <form method="POST" action="{{ route('んー…', ['review' => $review->id]) }}" class="col-5 mb-3">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-light btn-block">😒<span class="hidden-xs-down"> んー…</span></button>
                                </form>
                                @endif
                                @if ($impression != 0)
                                <form method="POST" action="{{ route('レビュー印象取り消し', ['review' => $review->id]) }}" class="col-5 mb-3">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-light btn-block">取り消し</button>
                                </form>
                                @endif
                                <div class="col-2 text-right">
                                    <button class="btn btn-light btn--icon" data-toggle="modal" data-target="#help"><i class="fas fa-question"></i></button>
                                </div>
                            </div>

                                <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header mb-0">
                                                <h5 class="modal-title" id="fmfm">🤔 ふむふむ</h5>
                                            </div>
                                            <div class="modal-body py-2">
                                                <p>どちらかというと好印象</p>
                                                <ul>
                                                    <li>文章がまとまっていて、読みやすい</li>
                                                    <li>書いてある意見に同意できる</li>
                                                    <li>意見には同意できないけど、レビューとしてよく書けている</li>
                                                </ul>
                                            </div>
                                            <div class="modal-header mb-0">
                                                <h5 class="modal-title" id="n-">😒 んー…</h5>
                                            </div>
                                            <div class="modal-body py-2">
                                                <p>どちらかというと悪印象</p>
                                                <ul>
                                                    <li>文章が読みにくい</li>
                                                    <li>書いてある意見に納得いかない</li>
                                                    <li>レビューになってない</li>
                                                </ul>
                                            </div>
                                            <div class="text-center mb-5">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @else
                            <p>印象を投稿するにはログインしてください。</p>
                            <div class="text-right mt-2">
                                <a href="{{ route('ログイン') }}" class="and-more">ログイン</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="card card-hgn border-info">
                <div class="card-body">
                    <h4 class="card-title">投稿者さま用</h4>
                    <form action="{{ route('レビュー削除', ['review' => $review->id]) }}" method="POST" onsubmit="return confirm('このレビューを削除してよろしいですか？')">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button class="btn btn-danger">削除する</button>
                    </form>
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

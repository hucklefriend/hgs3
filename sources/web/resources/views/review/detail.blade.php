@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー@endsection
@section('global_back_link'){{ route('レビュートップ') }}@endsection


@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p class="mb-0">{{ $user->name }}さんのレビュー</p>
        </header>

        @include('review.common.show', ['review' => $review])

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">レビューの印象</h5>
                        @auth
                            @if (!$isWriter)
                                <form method="POST" action="{{ route('レビュー印象', ['review' => $review->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-light mr-2 px-2">🤔 ふむふむ</button>
                                    <button class="btn btn-light px-2">😒 んー…</button>
                                </form>
                            @else
                                <p>レビュー投稿者はできません。</p>
                            @endif
                        @else
                            <p>印象を評価するにはログインしてください。</p>
                            <div class="text-right mt-2">
                                <a href="{{ route('ログイン') }}" class="badge badge-pill and-more">ログイン</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <div class="d-flex flex-wrap site-info">
                        <span class="capsule">
                            <span class="capsule-title">投稿者</span>
                            <span class="capsule-body"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">{{ $user->name }}</a></span>
                        </span>
                        <span class="capsule">
                            <span class="capsule-title">投稿日時</span>
                            <span class="capsule-body">{{ format_date(strtotime($review->post_at)) }}</span>
                        </span>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
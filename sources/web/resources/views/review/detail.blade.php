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

        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex flex-wrap site-info">
                    <span>
                        <i class="far fa-user"></i>
                        <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">{{ $user->name }}</a>
                    </span>
                    <span>
                    <span class="good-icon"><i class="fas fa-thumbs-up"></i></span>
                        {{ number_format($review->good_num) }}
                    </span>
                    <span>
                        <i class="far fa-calendar-alt"></i>
                        {{ format_date(strtotime($review->post_at)) }}
                    </span>
                </div>

                @if (Auth::check() && !$isWriter)
                <div class="mt-3">
                    @if ($hasGood)
                    <form method="POST" action="{{ route('レビューいいね取消', ['review' => $review->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-good2 btn--icon"><i class="fas fa-thumbs-up"></i></button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('レビューいいね', ['review' => $review->id]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-good btn--icon"><i class="far fa-thumbs-up"></i></button>
                    </form>
                    @endif
                </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
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
    </div>

    @auth
    <hr>

    <section>
        @if (!$isWriter)
        <a href="{{ url('review/fraud_report/report') }}/{{ $review->id }}">このレビューを不正報告</a> |
        @endif
        <a href="{{ url('review/fraud_report/list') }}/{{ $review->id }}">このレビューへの不正報告一覧</a>
    </section>

        @if ($isWriter)
            <section>
                <a href="{{ url2('review/edit') }}/{{ $review->id }}">レビューを修正・削除</a>
            </section>
        @endif
    @endauth
@endsection
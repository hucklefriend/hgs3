@extends('layouts.app')

@section('title')新着レビュー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::reviewNewList() }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1 class="mb-2">レビュー</h1>
            <p>3ヶ月以内に投稿されたレビューの一覧</p>
        </header>

        <div class="row">
            @foreach ($reviews as $review)
                @include('review.common.card', ['review' => $review])
            @endforeach
        </div>

        {{ $reviews->links() }}
    </div>

@endsection
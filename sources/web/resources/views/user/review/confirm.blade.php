@extends('layouts.app')

@section('title')レビュー投稿@endsection
@section('global_back_link'){{ route('レビュー入力', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p class="mb-0">{{ $user->name }}さんのレビュー(公開前の確認用)</p>
        </header>

        @include('review.common.show', ['review' => $draft])

        <p class="alert alert-info" role="alert">
            レビュー公開後は、修正することができません。<br>
            削除はできますが、削除後半年は同じゲームのレビューを書くことができません。<br>
            よくよくご確認の上、公開してください。
        </p>


        <div class="row">
            <div class="col-6 text-center">
                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="btn btn-light">修正する</a>
            </div>
            <div class="col-6">
                <form method="POST" action="{{ route('レビュー公開', ['soft' => $soft->id]) }}" autocomplete="off" class="text-center" onsubmit="return confirm('このレビューを公開します。\nよろしいですね？');">
                    <input type="hidden" name="soft_id" value="{{ $soft->id }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <button class="btn btn-primary">レビューを公開する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}">レビュー</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー投稿</li>
        </ol>
    </nav>
@endsection

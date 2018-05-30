@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿　プレイ状況編集</p>
        </header>

        <form method="POST" action="{{ route('レビュー悪い点保存', ['soft' => $soft->id]) }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="bad_comment" class="hgn-label"><i class="fas fa-edit"></i> 悪い点コメント</label>
                <p class="text-muted">
                    このゲームの悪い点について、言いたいことがあれば記入してください。
                </p>
                <textarea name="bad_comment" id="bad_comment" class="form-control textarea-autosize{{ invalid($errors, 'bad_comment') }}">{{ old('bad_comment', $draft->bad_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                <small>最大文字数：10,000</small>
                @include('common.error', ['formName' => 'bad_comment'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">悪い点を保存</button>
            </div>
        </form>
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

@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿</p>
        </header>

        <form method="POST" action="{{ route('レビュー保存') }}" autocomplete="off">
            <input type="hidden" name="soft_id" value="{{ $soft->id }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="good_comment" class="hgn-label"><i class="fas fa-edit"></i> 良い点コメント</label>
                <p class="text-muted">
                    このゲームの良い点について、言いたいことがあれば記入してください。
                </p>
                <textarea name="good_comment" id="good_comment" class="form-control textarea-autosize{{ invalid($errors, 'good_comment') }}">{{ old('good_comment', $draft->good_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'good_comment'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">良い点を保存</button>
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

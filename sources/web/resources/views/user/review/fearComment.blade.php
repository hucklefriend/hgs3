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
                <label for="fear_comment" class="hgn-label"><i class="fas fa-edit"></i> 怖さコメント</label>
                <p class="text-muted">
                    怖さについて、言いたいことがあれば記入してください。
                </p>
                <textarea name="fear_comment" id="fear_comment" class="form-control textarea-autosize{{ invalid($errors, 'fear_comment') }}">{{ old('fear_comment', $draft->fear_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'fear_comment'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">怖さコメントを保存</button>
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

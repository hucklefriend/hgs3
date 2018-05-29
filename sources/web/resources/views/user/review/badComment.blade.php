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
                <label for="bad_comment" class="hgn-label"><i class="fas fa-edit"></i> 悪い点コメント</label>
                <p class="text-muted">
                    このゲームの悪い点について、言いたいことがあれば記入してください。
                </p>
                <textarea name="bad_comment" id="bad_comment" class="form-control textarea-autosize{{ invalid($errors, 'bad_comment') }}">{{ old('bad_comment', $draft->bad_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'bad_comment'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">下書き保存して確認画面へ</button>
                <p class="text-muted mt-2">
                    <small>
                        下書き保存でも必須項目の入力は必要です。<br>
                        下書き保存してもまだ公開はされません。<br>
                        次の確認画面で公開することによって初めて公開されます。
                    </small>
                </p>
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

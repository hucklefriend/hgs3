@extends('layouts.app')

@section('title')レビュー投稿@endsection
@section('global_back_link'){{ route('レビュー入力', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー投稿確認</h1>
        </header>

        @include('review.common.show', ['review' => $draft])



        <form method="POST" action="{{ route('レビュー公開') }}" autocomplete="off" class="text-center" onsubmit="return confirm('このレビューを公開します。\nよろしいですね？');">
            <input type="hidden" name="soft_id" value="{{ $soft->id }}">
            {{ csrf_field() }}

            <div class="form-group">
                <button class="btn btn-primary">レビューを公開する</button>
                <p class="text-muted">
                    <small>
                        レビュー公開後は、編集できなくなります。<br>
                        よくよくご確認の上、公開してください。
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

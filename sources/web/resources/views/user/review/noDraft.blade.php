@extends('layouts.app')

@section('title')レビュー未保存@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>下書きのレビューがありません。</h1>
        </header>

        <p>下書きのレビューがないため、公開できません。</p>
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

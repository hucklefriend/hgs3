@extends('layouts.app')

@section('title')レビュー投稿不可@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー投稿できません</h1>
        </header>

        <p>このゲームのレビューを削除してから半年経過しないと、レビューの投稿はできません。</p>
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

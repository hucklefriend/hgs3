@extends('layouts.app')

@section('title')レビュー投稿済み@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー投稿済み</h1>
        </header>

        <p>このゲームのレビューは投稿済みです。</p>
    </div>
@endsection


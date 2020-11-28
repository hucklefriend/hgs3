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

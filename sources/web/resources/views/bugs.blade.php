@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>バグ</h1>

    <p class="text-muted">
        現在把握しているバグの一覧です。<br>
        ここに載っていないバグを見かけられましたら、管理人までご一報ください。<br>
        連絡先
        <a href="mailto:webmaster@horrorgame.net" class="mx-1"><i class="far fa-envelope-open"></i></a>
        <a href="https://twitter.com/huckle_friend" class="mx-1">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</a>
    </p>

    @foreach ($bugs as $bug)
        <div class="my-3">
            <div>{{ $bug['date'] }}<span class="badge badge-info ml-2">{{ $bug['status'] }}</span></div>
            <div style="font-size: 1.2rem; font-weight: bold;">{{ $bug['title'] }}</div>
            <div class="pl-2">{{ nl2br(e($bug['message'])) }}</div>
        </div>
    @endforeach
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">バグ</li>
        </ol>
    </nav>
@endsection
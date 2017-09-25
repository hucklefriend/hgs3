@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">マイページメニュー</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('user/profile') }}">プロフィール確認</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('user/follow') }}/{{ $user->id }}">フォロー</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('mypage/follower') }}">フォロワー</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('mypage/review') }}">レビュー</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('user/site/myself') }}">サイト</a>
                </li>
            </ul>
        </div>
    </nav>

    <hr>

    <section>
        <h5>タイムライン</h5>
        {{ $pager->render() }}

        @foreach ($timelines as $tl)

            <div>{{ date('Y-m-d H:i:s', $tl['time']) }} type: {{ $tl['type'] }}</div>
            <p>{!!  $tl['text'] !!}</p>
            <hr>

        @endforeach
    </section>

@endsection
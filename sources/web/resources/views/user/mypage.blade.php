@extends('layouts.app')

@section('content')

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mypage_menu" aria-controls="mypage_menu" aria-expanded="false" aria-label="">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mypage_menu">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('user/profile') }}">プロフィール</a>
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

        @foreach ($timelines as $tl)
            <div>{{ date('Y-m-d H:i:s', $tl['time']) }}</div>
            <p>{!!  $tl['text'] !!}</p>
            <hr>
        @endforeach
        {{ $pager->render() }}
    </section>

@endsection
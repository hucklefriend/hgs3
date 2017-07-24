@extends('layouts.app')

@section('content')

    <nav>
        <a href="{{ url('site/search') }}">サイト一覧</a>
    </nav>


    <hr>

    <section>
        <h4>{{ $site->name }}</h4>
        <div>{{ $site->name }}</div>
        <div>
            URL: <a href="{{ url('/site/go') }}/{{ $site->id }}">{{ $site->url }}</a>
        </div>
        <div>
            取扱いゲーム: {{ $handleGames }}
        </div>
        <pre>{{ $site->presentation }}</pre>
    </section>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"></div>
    </div>
@endsection
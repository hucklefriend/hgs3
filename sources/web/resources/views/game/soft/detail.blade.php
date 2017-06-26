@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ $soft['name'] }}</h4>

        <nav>
            データ編集 |
        </nav>

        <div class="row">
            <div class="col-3">メーカー</div>
            <div class="col-8">
                @if($soft['company'] != null)
                    <a href="">{{ $soft['company']->name }}</a>
                @endif
            </div>
        </div>

        <h5>パッケージ</h5>
        @foreach ($soft['packages'] as $pkg)
        <div class="row">
            <div class="col-2">
                <img src="{{ $pkg->medium_image_url }}" class="thumbnail" style="max-width: 100%;">
            </div>
            <div class="col-9">
                <div>{{ $pkg->name }}</div>
                <div>{{ $pkg->platform_name }}</div>
                <div>{{ $pkg->release_date }}</div>
                <div>
                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                </div>
            </div>
        </div>
        @endforeach

        @if($soft['series'] != null)
            <h5>{{ $soft['series']['name'] }}シリーズの別タイトル</h5>
            <ul class="list-group">
                @foreach ($soft['series']['list'] as $sl)
                <li class="list-group-item">
                    <a href="{{ url('game/soft') }}/{{$sl->id}}">{{ $sl->name }}</a>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
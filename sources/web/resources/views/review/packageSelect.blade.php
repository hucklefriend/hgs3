@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}のレビューを書く</h4>
    <div>
        <a href="{{ url2('game/soft') }}/{{ $game->id }}">ゲームの詳細</a> |
        <a href="{{ url2('review/soft') }}/{{ $game->id }}">同じゲームのレビュー一覧</a>
    </div>

    <hr>


    <div class="alert alert-info" role="alert">
        レビューを書くパッケージを選んでください。<br>
        パッケージ毎にレビューを投稿できます。
    </div>


    @foreach ($packages as $pkg)
        <div class="d-flex align-items-stretch">
            <div class="align-self-top p-2">
                @include ('game.common.package_image', ['imageUrl' => $pkg->small_image_url])
            </div>
            <div class="align-self-top">
                <div>
                    <strong>{{ $pkg->name }}</strong>
                </div>
                <div>
                    <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<a href="{{ url2('game/company') }}/{{ $pkg->company_id }}">{{ $pkg->company_name }}</a>
                    <i class="fa fa-gamepad" aria-hidden="true"></i>&nbsp;{{ $pkg->platform_name }}
                </div>
                <div>
                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url2('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                </div>
            </div>
        </div>
        <div style="margin: 10px 8px;">
            <span style="padding: 5px 0;">
        @if (isset($drafts[$pkg->id]))
            <i class="fa fa-pencil" aria-hidden="true"></i>
            <a href="{{ url2('review/write') }}/{{ $pkg->id }}">このパッケージのレビューを書く</a>
        @elseif (isset($written[$pkg->id]))
            <p>このパッケージのレビューは投稿済みです。</p>
            <a href="{{ url2('review/detail') }}/{{ $written[$pkg->id] }}">このパッケージのレビューを確認</a>
        @else
            <i class="fa fa-pencil" aria-hidden="true"></i>
            <a href="{{ url2('review/write') }}/{{ $pkg->id }}">このパッケージのレビューを書く</a>
        @endif
            </span>
        </div>

        @if (!$loop->last) <hr> @endif
    @endforeach

    <br><br>

@endsection

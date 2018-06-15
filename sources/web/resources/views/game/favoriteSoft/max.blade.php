@extends('layouts.app')

@section('title'){{ $soft->name }}をお気に入り登録しているユーザー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::gameFavoriteUserList($soft) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>お気に入り登録できませんでした。</h1>
        </header>

        <p>
            お気に入りに登録できるゲームは、{{ \Hgs3\Constants\User\FavoriteSoft::MAX }}個までです。<br>
            何かの登録を解除してから、登録してください。
        </p>
    </div>
@endsection

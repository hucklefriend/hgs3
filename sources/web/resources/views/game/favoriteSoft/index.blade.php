@extends('layouts.app')

@section('content')

    <h4><a href="{{ url2('game/soft/' . $soft->id) }}">{{ $soft->name }}</a>をお気に入りに登録しているユーザー</h4>

    @foreach ($favoriteUsers as $favoriteUser)
        <div class="row">
            <div class="col-1">
                @include('user.common.icon', ['u' => $users[$favoriteUser->user_id]])
            </div>
            <div class="col-10">
                @include('user.common.user_name', ['id' => $favoriteUser->id, 'name' => $users[$favoriteUser->user_id]->name])
            </div>
        </div>
        <hr>
    @endforeach

    {{ $favoriteUsers->links() }}

@endsection
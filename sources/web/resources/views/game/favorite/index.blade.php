@extends('layouts.app')

@section('content')

    <h4><a href="{{ url('game/soft/detail') }}/{{ $game->id }}">{{ $game->name }}</a>をお気に入りに登録しているユーザー</h4>

    @foreach ($pager as $item)
        <div class="row">
            <div class="col-1">
                @include('user.common.icon', ['u' => $users[$item->user_id]])
            </div>
            <div class="col-10">
                @include('user.common.user_name', ['id' => $item->id, 'name' => $users[$item->user_id]->name])
            </div>
        </div>
        <hr>
    @endforeach

    {{ $pager->links() }}

@endsection
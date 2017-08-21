@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('game/soft/detail') }}/{{ $game->id }}">詳細に戻る</a>
    </div>

    <div>
        @foreach ($pager as $item)
            <div class="row">
                <div class="col-2"></div>
                <div class="col-10">
                    <a href="{{ url('user/profile') }}/{{ $item->user_id }}">{{ $users[$item->user_id] }}</a>
                    <pre>{{ $item->comment }}</pre>
                </div>
            </div>
            <hr>
        @endforeach
    </div>

    {{ $pager->links() }}

@endsection
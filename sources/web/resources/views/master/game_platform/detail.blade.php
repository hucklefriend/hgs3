@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ url('master/game_platform') }}">戻る</a>
        </div>

        <div>
            <a href="{{ url('master/game_platform') }}/{{ $gamePlatform->id }}/edit">編集</a>
        </div>

        <div class="row">
            <div class="col-3">名称</div>
            <div class="col-9">{{ $gamePlatform->name }}</div>
        </div>
        <div class="row">
            <div class="col-3">略称</div>
            <div class="col-9">{{ $gamePlatform->acronym }}</div>
        </div>
        <div class="row">
            <div class="col-3">表示順</div>
            <div class="col-9">{{ $gamePlatform->sort_order }}</div>
        </div>


        <form action="{{ url('master/game_platform') }}/{{ $gamePlatform->id }}" method="POST">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button class="btn btn-danger">削除</button>
        </form>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ url('master/game_company') }}">戻る</a>
        </div>

        <div>
            <a href="{{ url('master/game_company') }}/{{ $gameCompany->id }}/edit">編集</a>
        </div>

        <div class="row">
            <div class="col-3">名称</div>
            <div class="col-9">{{ $gameCompany->name }}</div>
        </div>
        <div class="row">
            <div class="col-3">ひらがな</div>
            <div class="col-9">{{ $gameCompany->name_hiragana }}</div>
        </div>
        <div class="row">
            <div class="col-3">URL</div>
            <div class="col-9">{{ $gameCompany->url }}</div>
        </div>


        <form action="{{ url('master/game_company') }}/{{ $gameCompany->id }}" method="POST">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button class="btn btn-danger">削除</button>
        </form>
    </div>
@endsection
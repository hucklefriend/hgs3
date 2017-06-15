@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ url('master/game_company') }}/{{ $gameCompany->id }}">戻る</a>
        </div>

        <form method="POST" action="{{ url('master/game_company') }}/{{ $gameCompany->id }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $gameCompany->name }}">
            </div>
            <div class="form-group">
                <label for="hiragana">よみがな</label>
                <input type="text" class="form-control" id="hiragana" name="name_hiragana" value="{{ $gameCompany->name_hiragana }}">
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control" id="url" name="url" value="{{ $gameCompany->url }}">
            </div>
            <button type="submit" class="btn btn-primary">登録</button>
        </form>

    </div>
@endsection
@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ url('master/game_company') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="hiragana">よみがな</label>
            <input type="text" class="form-control" id="hiragana" name="name_hiragana">
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control" id="url" name="url">
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
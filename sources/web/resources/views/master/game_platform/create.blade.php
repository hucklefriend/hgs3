@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ url('master/game_platform') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="acronym">略称</label>
            <input type="text" class="form-control" id="acronym" name="acronym">
        </div>
        <div class="form-group">
            <label for="sort_order">表示順</label>
            <input type="text" class="form-control" id="sort_order" name="sort_order">
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
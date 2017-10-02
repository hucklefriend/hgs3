@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ url2('game/soft/add') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="name">よみがな</label>
            <input type="text" class="form-control" id="phonetic" name="phonetic" value="{{ old('phonetic') }}" required>
        </div>
        <div class="form-group">
            <label for="phonetic_order">よみがなでの表示順</label>
            <input type="text" class="form-control" id="phonetic_order" name="phonetic_order" value="{{ old('phonetic_order') }}" required>
        </div>
        <div class="form-group">
            <label for="name">ジャンル</label>
            <input type="text" class="form-control" id="genre" value="{{ old('genre') }}" name="genre">
        </div>

        <div class="form-group">
            <label for="company">会社</label>
            {{ company_select(old('company_id'), true) }}
        </div>

        <div class="form-group">
            <label for="company">シリーズ</label>
            {{ series_select(old('series_id'), true) }}
        </div>
        <div class="form-group">
            <label for="company">シリーズ内での表示順</label>
            <input type="number" min="0" value="{{ old('order_in_series') }}" class="form-control" name="order_in_series">
        </div>
        <div class="form-group">
            <label for="game_type">ゲーム区分</label>
            {{ game_type_select(old('game_type')) }}
        </div>

        <button class="btn btn-primary">登録</button>



    </form>
@endsection
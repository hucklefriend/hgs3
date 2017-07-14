@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ $game->name }}</h4>

        <nav style="margin-bottom: 20px;">
            <a href="{{ url('game/soft') }}/{{ $game->id }}">データ詳細に戻る</a>
        </nav>

        <form method="POST">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control" id="name" value="{{ $game->name }}" name="name">
            </div>
            <div class="form-group">
                <label for="phonetic">よみがな</label>
                <input type="text" class="form-control" id="phonetic" value="{{ $game->phonetic }}" name="phonetic">
            </div>
            <div class="form-group">
                <label for="phonetic_order">よみがなでの表示順</label>
                <input type="text" class="form-control" id="phonetic_order" value="{{ $game->phonetic_order }}" name="phonetic_order">
            </div>
            <div class="form-group">
                <label for="genre">ジャンル</label>
                <input type="text" class="form-control" id="genre" value="{{ $game->genre }}" name="genre">
            </div>
            <div class="form-group">
                <label for="company_id">メーカー</label>
                {{ company_select($game->company_id, true) }}
            </div>
            <div class="form-group">
                <label for="series_id">シリーズ</label>
                {{ series_select($game->series_id, true) }}
                <p>シリーズを追加</p>
            </div>
            <div class="form-group">
                <label for="order_in_series">シリーズ内での表示順</label>
                <input type="number" min="0" value="{{ $game->order_in_series }}" class="form-control" name="order_in_series">
            </div>
            <div class="form-group">
                <label for="game_type">ゲーム区分</label>
                {{ game_type_select($game->game_type) }}
            </div>
            <div class="form-group">
                <button class="btn btn-primary">更新</button>
            </div>
        </form>
@endsection
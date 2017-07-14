@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}のパッケージ追加</h4>

    <nav style="margin-bottom: 20px;">
        <a href="{{ url('game/soft') }}/{{ $game->id }}">データ詳細に戻る</a>
    </nav>

    <form method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control" id="name" value="" name="name">
        </div>

        <div class="form-group">
            <label for="phonetic">プラットフォーム</label>
            {{ platform_select(null) }}
        </div>

        <div class="form-group">
            <label for="company_id">メーカー</label>
            {{ company_select($game->company_id, true) }}
        </div>

        <div class="form-group">
            <label for="url">公式サイト</label>
            <input type="text" class="form-control" id="url" value="" name="url">
        </div>

        <div class="form-group">
            <label for="release_date">発売日</label>
            <input type="text" class="form-control" id="release_date" value="" name="release_date">
        </div>

        <div class="form-group">
            <label for="release_int">発売日(数値)</label>
            <input type="text" class="form-control" id="release_int" value="" name="release_int">
        </div>

        <div class="form-group">
            <label for="release_int">ゲーム区分</label>
            {{ game_type_select($game->game_type) }}
        </div>

        <div class="form-group">
            <label for="asin">ASIN</label>
            <input type="text" class="form-control" id="release_int" value="" name="asin">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">登録</button>
        </div>
    </form>
@endsection

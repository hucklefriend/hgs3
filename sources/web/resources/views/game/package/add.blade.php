@extends('layouts.app')

@section('content')
    <h4>{{ $soft->name }}のパッケージ追加</h4>

    <nav style="margin-bottom: 20px;">
        <a href="{{ url('game/soft/' . $soft->id }}">データ詳細に戻る</a>
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
            {{ company_select($soft->company_id, true) }}
        </div>

        <div class="form-group">
            <label for="url">公式サイト</label>
            <input type="text" class="form-control" id="url" value="" name="url">
        </div>

        <div class="form-group">
            <label for="release_at">発売日</label>
            <input type="text" class="form-control" id="release_at" value="" name="release_at">
        </div>

        <div class="form-group">
            <label for="release_int">発売日(数値)</label>
            <input type="text" class="form-control" id="release_int" value="" name="release_int">
        </div>

        <div class="form-group">
            <label for="asin">ASIN</label>
            <input type="text" class="form-control" id="asin" value="" name="asin">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">登録</button>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('content')
    <h4>{{ $gameSoft->name }}のパッケージ編集</h4>

    <nav style="margin-bottom: 20px;">
        <a href="{{ url('game/soft/' . $gameSoft->id }}">データ詳細に戻る</a>
    </nav>

    <form method="POST">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control" id="name" value="{{ $pkg->name }}" name="name">
        </div>

        <div class="form-group">
            <label for="phonetic">プラットフォーム</label>
            {{ platform_select($pkg->platform_id) }}
        </div>

        <div class="form-group">
            <label for="company_id">メーカー</label>
            {{ company_select($pkg->company_id, true) }}
        </div>

        <div class="form-group">
            <label for="url">公式サイト</label>
            <input type="text" class="form-control" id="url" value="{{ $pkg->url }}" name="url">
        </div>

        <div class="form-group">
            <label for="release_at">発売日</label>
            <input type="text" class="form-control" id="release_at" value="{{ $pkg->release_at }}" name="release_at">
        </div>

        <div class="form-group">
            <label for="release_int">発売日(数値)</label>
            <input type="text" class="form-control" id="release_int" value="{{ $pkg->release_id }}" name="release_int">
        </div>

        <div class="form-group">
            <label for="release_int">ゲーム区分</label>
            {{ game_type_select($pkg->game_type_id) }}
        </div>

        <div class="form-group">
            <label for="asin">ASIN</label>
            <input type="text" class="form-control" id="asin" value="{{ $pkg->asin }}" name="asin">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">更新</button>
        </div>
    </form>
@endsection

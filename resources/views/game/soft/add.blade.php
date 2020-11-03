@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム一覧') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <p>
        <a href="{{ route('シリーズ登録') }}?from=game_add">シリーズの追加はこちら</a>
    </p>

    <form method="POST" action="{{ route('ゲームソフト登録処理') }}" autocomplete="off">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="series_id">シリーズ</label>
            {{ series_select(old('series_id'), true) }}
        </div>

        <div class="form-group">
            <label for="order_in_series">シリーズ内での表示順</label>
            <input type="number" min="0" value="{{ old('order_in_series') }}" class="form-control{{ invalid($errors, 'order_in_series') }}" name="order_in_series" maxlength="5">
            @include('common.error', ['formName' => 'order_in_series'])
        </div>

        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name') }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="phonetic">よみがな</label>
            <input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic') }}" required maxlength="100">
            @include('common.error', ['formName' => 'phonetic'])
        </div>
        <div class="form-group">
            <label for="genre">ジャンル</label>
            <input type="text" class="form-control{{ invalid($errors, 'genre') }}" id="genre" value="{{ old('genre') }}" name="genre" maxlength="100">
            @include('common.error', ['formName' => 'genre'])
        </div>

        <button class="btn btn-primary">登録</button>
    </form>
@endsection

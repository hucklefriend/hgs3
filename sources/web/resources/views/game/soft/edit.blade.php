@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ $soft->name }}を編集</h1>

    <form method="POST" action="{{ route('ゲームソフト編集処理', ['soft' => $soft->id]) }}" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $soft->name) }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="phonetic">よみがな</label>
            <input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', $soft->phonetic) }}" required maxlength="100">
            @include('common.error', ['formName' => 'phonetic'])
        </div>
        <div class="form-group">
            <label for="phonetic_order">よみがなでの表示順</label>
            <input type="number" class="form-control{{ invalid($errors, 'phonetic_order') }}" id="phonetic_order" name="phonetic_order" value="{{ old('phonetic', $soft->phonetic_order) }}" required max="99999">
            @include('common.error', ['formName' => 'phonetic_order'])
        </div>
        <div class="form-group">
            <label for="genre">ジャンル</label>
            <input type="text" class="form-control{{ invalid($errors, 'genre') }}" id="genre" value="{{ old('genre', $soft->genre) }}" name="genre" maxlength="100">
            @include('common.error', ['formName' => 'genre'])
        </div>
        <div class="form-group">
            <label for="series_id">シリーズ</label>
            {{ series_select($soft->series_id, true) }}
            <p>シリーズを追加</p>
        </div>
        <div class="form-group">
            <label for="order_in_series">シリーズ内での表示順</label>
            <input type="number" class="form-control{{ invalid($errors, 'order_in_series') }}" id="order_in_series" name="order_in_series" value="{{ old('order_in_series', $soft->order_in_series) }}" max="99999">
            @include('common.error', ['formName' => 'order_in_series'])
        </div>
        <div class="form-group">
            <button class="btn btn-primary">更新</button>
        </div>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">編集</li>
        </ol>
    </nav>
@endsection

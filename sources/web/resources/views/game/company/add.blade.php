@extends('layouts.app')

@section('title')ゲーム会社@endsection
@section('global_back_link'){{ route('ゲーム会社一覧') }}@endsection

@section('content')
    <h1>ゲーム会社新規登録</h1>

    <form method="POST" action="{{ route('ゲーム会社登録処理') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name') }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="phonetic">よみがな</label>
            <input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic') }}">
            @include('common.error', ['formName' => 'phonetic'])
        </div>
        <div class="form-group">
            <label for="acronym">略称</label>
            <input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym') }}">
            @include('common.error', ['formName' => 'acronym'])
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url') }}" maxlength="500">
            @include('common.error', ['formName' => 'url'])
        </div>
        <div class="form-group">
            <label for="url">Wikipedia URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'wikipedia') }}" id="wikipedia" name="wikipedia" value="{{ old('wikipedia') }}" maxlength="500">
            @include('common.error', ['formName' => 'wikipedia'])
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム会社一覧') }}">ゲーム会社一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">新規登録</li>
        </ol>
    </nav>
@endsection
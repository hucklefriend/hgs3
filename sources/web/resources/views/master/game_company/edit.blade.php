@extends('layouts.master')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-master">
            <li class="breadcrumb-item"><a href="{{ url2('') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/master') }}">マスター</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/master/game_company') }}">ゲーム会社</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $gameCompany->name }}の編集</li>
        </ol>
    </nav>

    @if($isComplete)
        <div class="alert alert-success auto-hide" role="alert" data-hide_time="3000">
            データを編集しました。
        </div>
    @endif

    <form method="POST">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $gameCompany->name) }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="acronym">略称</label>
            <input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', $gameCompany->acronym) }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'acronym'])
        </div>
        <div class="form-group">
            <label for="phonetic">よみがな</label>
            <input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', $gameCompany->phonetic) }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'phonetic'])
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('name', $gameCompany->url) }}" maxlength="500" autocomplete="off">
            @include('common.error', ['formName' => 'url'])
        </div>
        <div class="form-group">
            <label for="url">Wikipedia URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'wikipedia') }}" id="wikipedia" name="wikipedia" value="{{ old('name', $gameCompany->wikipedia) }}" maxlength="500" autocomplete="off">
            @include('common.error', ['formName' => 'wikipedia'])
        </div>
        <button type="submit" class="btn btn-primary">編集</button>
    </form>
@endsection
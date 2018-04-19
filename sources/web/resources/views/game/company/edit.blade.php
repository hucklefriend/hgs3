@extends('layouts.app')

@section('title')ゲーム会社@endsection
@section('global_back_link'){{ route('ゲーム会社詳細', ['company' => $company->id]) }}@endsection

@section('content')
    <form method="POST" action="{{ route('ゲーム会社編集処理', ['company' => $company->id]) }}" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $company->name) }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="phonetic">よみがな</label>
            <input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', $company->phonetic) }}" required maxlength="100">
            @include('common.error', ['formName' => 'phonetic'])
        </div>
        <div class="form-group">
            <label for="acronym">略称</label>
            <input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', $company->acronym) }}" required maxlength="100">
            @include('common.error', ['formName' => 'acronym'])
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('name', $company->url) }}" maxlength="500">
            @include('common.error', ['formName' => 'url'])
        </div>
        <div class="form-group">
            <label for="url">Wikipedia URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'wikipedia') }}" id="wikipedia" name="wikipedia" value="{{ old('name', $company->wikipedia) }}">
            @include('common.error', ['formName' => 'wikipedia'])
        </div>
        <button type="submit" class="btn btn-primary">編集</button>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム会社一覧') }}">ゲーム会社一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム会社詳細', ['c' => $company->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">編集</li>
        </ol>
    </nav>
@endsection

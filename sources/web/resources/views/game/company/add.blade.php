@extends('layouts.app')

@section('content')
    <form method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="hiragana">よみがな</label>
            <input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic') }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'phonetic'])
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url') }}" maxlength="500" autocomplete="off">
            @include('common.error', ['formName' => 'url'])
        </div>
        <div class="form-group">
            <label for="url">Wikipedia URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'wikipedia') }}" id="wikipedia" name="wikipedia" value="{{ old('wikipedia') }}" maxlength="500" autocomplete="off">
            @include('common.error', ['formName' => 'wikipedia'])
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
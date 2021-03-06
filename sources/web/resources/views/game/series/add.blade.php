@extends('layouts.app')

@section('content')
    <form method="POST" autocomplete="off">
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
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
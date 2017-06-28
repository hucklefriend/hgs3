@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ url('game/company') }}/{{ $gameCompany->id }}">戻る</a>
        </div>

        <form method="POST" action="{{ url('game/company') }}/{{ $gameCompany->id }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $gameCompany->name }}">
            </div>
            <div class="form-group">
                <label for="hiragana">よみがな</label>
                <input type="text" class="form-control" id="phonetic" name="phonetic" value="{{ $gameCompany->phonetic }}">
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control" id="url" name="url" value="{{ $gameCompany->url }}">
            </div>
            <div class="form-group">
                <label for="url">Wikipedia URL</label>
                <input type="text" class="form-control" id="wikipedia" name="wikipedia" value="{{ $gameCompany->wikipedia }}">
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>

    </div>
@endsection
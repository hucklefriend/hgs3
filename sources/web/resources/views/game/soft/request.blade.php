@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ url('game/soft/request') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="url">公式サイトURL</label>
            <input type="text" class="form-control" id="url" name="url">
        </div>
        <div class="form-group">
            <label for="url">プラットフォーム</label><br>
            @foreach ($platforms as $p)
            <div class="form-check form-check-inline">
                <label class="form-check-label"><input class="form-check-input" type="checkbox" value="{{ $p->id }}">&nbsp;{{ $p->name }}</label>
            </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="url">その他</label>
            <textarea name="other" class="form-control"></textarea>
            <p class="help-block">amazonのURLなど何かあれば</p>
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
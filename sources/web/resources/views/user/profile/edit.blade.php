@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('user/profile') }}">プロフィールに戻る</a>
    </div>

@if ($isUpdated)
    <div class="alert alert-success" role="alert">
        更新しました。
    </div>
@endif
    <form method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" value="1" name="adult" @if ($user->adult == 1) checked @endif >
                18歳以上
            </label>
        </div>
        <div class="form-group">
            <button class="btn btn-default">更新</button>
        </div>
    </form>

@endsection
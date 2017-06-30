@extends('layouts.app')

@section('content')

    <p>{{ $game->name }}の編集リクエスト</p>

    <form method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="comment">その他</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url2('timeline') }}">戻る</a>
    </div>

    <hr>

    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_GAME_SOFT  }}">
        <h5>ゲームソフト追加</h5>
        <div class="form-group row">
            <div class="col-3">ID</div>
            <div class="col-9"><input type="number" name="game_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::UPDATE_GAME_SOFT  }}">
        <h5>ゲームソフト更新</h5>
        <div class="form-group row">
            <div class="col-3">ID</div>
            <div class="col-9"><input type="number" name="game_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
@endsection
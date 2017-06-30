@extends('layouts.app')

@section('content')
    <ul>
        <li><a href="{{ url('game/request') }}">リクエスト一覧へ</a></li>
        <li><a href="{{ url('game/request/input') }}">リクエスト入力へ</a></li>

        <li><a href="{{ url('game/soft') }}">ソフト一覧へ</a></li>
    </ul>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $game->name }}</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">@if($user == null)ゲスト@else{{ $user->name }}@endif</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gur->comment }}</div>
    </div>


    @if($isAdmin)
    <form method="POST">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">対応状況</label>
            <div class="col-sm-10">
                {{ Form::select('status', \Hgs3\Constants\GameRequestStatus::getSelectOptions(), 0, ['class' => 'form-control', 'id' => 'status']) }}
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">コメント</label>
            <div class="col-sm-10">
                <textarea id="admin_comment" name="admin_comment" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button class="btn btn-default">送信</button>
            </div>
        </div>
    </form>
    @endif

@endsection
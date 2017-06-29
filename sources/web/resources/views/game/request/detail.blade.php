@extends('layouts.app')

@section('content')
    <ul>
        <li><a href="{{ url('game/request') }}">リクエスト一覧へ</a></li>
        <li><a href="{{ url('game/request/input') }}">リクエスト入力へ</a></li>

        <li><a href="{{ url('game/soft') }}">ソフト一覧へ</a></li>
    </ul>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gar->name }}</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">@if($user == null)ゲスト@else{{ $user->name }}@endif</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gar->url }}</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gar->other }}</div>
    </div>


    @if($isAdmin)
    <form method></form>
    @endif

@endsection
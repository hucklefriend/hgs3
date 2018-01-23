@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <h1>登録できません</h1>
    <p>入力されたメールアドレスは利用できません。</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー登録') }}">ユーザー登録</a></li>
            <li class="breadcrumb-item active" aria-current="page">登録エラー</li>
        </ol>
    </nav>
@endsection
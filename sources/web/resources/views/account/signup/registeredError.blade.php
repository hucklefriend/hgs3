@extends('layouts.app')

@section('title')ユーザー登録@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <h1>登録できません</h1>
    <p>入力されたメールアドレスは利用できません。</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー登録') }}">ユーザー登録</a></li>
            <li class="breadcrumb-item active" aria-current="page">登録エラー</li>
        </ol>
    </nav>
@endsection

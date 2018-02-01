@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト管理') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>登録できません。</h1>
    <p>
        登録できるサイトは10個までです。
    </p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト管理') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト登録</li>
        </ol>
    </nav>
@endsection
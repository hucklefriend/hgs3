@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ route('サイトトップ') }}@endsection

@section('content')
    <h1>アクセスできません。</h1>
    <p>こちらのサイトは承認されていないか、非公開にされているため表示できません。</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト詳細</li>
        </ol>
    </nav>
@endsection
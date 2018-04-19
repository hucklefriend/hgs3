@extends('layouts.app')

@section('title')ゲーム会社@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')

    <h1>ゲーム会社一覧</h1>
    <ul class="list-group no-border">
    @foreach ($companies as $c)
        <li class="list-group-item"><a href="{{ route('ゲーム会社詳細', ['company' => $c->id]) }}">{{ $c->name }}</a></li>
    @endforeach
    </ul>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ゲーム会社一覧</li>
        </ol>
    </nav>
@endsection
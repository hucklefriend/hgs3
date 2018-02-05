@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>ゲーム会社一覧</h1>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('ゲーム会社登録') }}" class="btn btn-sm btn-outline-info">ゲーム会社を追加</a>
    </div>
    @endif

    <ul class="list-group">
    @foreach ($companies as $c)
        <li class="list-group-item"><a href="{{ route('ゲーム会社詳細', ['company' => $c->id]) }}">{{ $c->name }}</a></li>
    @endforeach
    </ul>

    @include('common.pager', ['pager' => $companies])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ゲーム会社一覧</li>
        </ol>
    </nav>
@endsection
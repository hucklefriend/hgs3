@extends('layouts.management')

@section('title', 'シリーズ登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-シリーズ') . session('search_series') }}">シリーズ</a></li>
        <li class="breadcrumb-item active">登録</li>
    </ol>
    <h1 class="page-header">シリーズ登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-シリーズ登録処理') }}">
            {{ csrf_field() }}
            <div class="panel-body">
                @include('management.master.series.form')
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">登録</button>
            </div>
        </form>
    </div>
@endsection

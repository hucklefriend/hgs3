@extends('layouts.management')

@section('title', 'パッケージ複製')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') . session('search_package') }}">パッケージ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ詳細', $model) }}">詳細</a></li>
        <li class="breadcrumb-item active">編集</li>
    </ol>
    <h1 class="page-header">パッケージ複製</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $model->name }}</h4>
        </div>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        <form method="POST" action="{{ route('管理-マスター-パッケージ複製処理', $model) }}">
            {{ csrf_field() }}

            <div class="panel-body">
                @include('management.master.package.form')
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">複製</button>
            </div>
        </form>
    </div>
@endsection
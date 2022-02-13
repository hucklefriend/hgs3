@extends('layouts.management')

@section('title', 'パッケージの販売ショップ更新')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') . session('search_package') }}">パッケージ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ詳細', $package) }}">詳細</a></li>
        <li class="breadcrumb-item active">販売ショップ更新</li>
    </ol>
    <h1 class="page-header">販売ショップ更新</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">更新</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-パッケージショップ更新処理', ['package' => $package, 'shop' => $model]) }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="panel-body">
                @include('management.master.package.shop_form')
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </form>
    </div>
@endsection

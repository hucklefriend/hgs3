@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム会社一覧') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    @if (is_data_editor())
        <div class="d-flex">
            <h1>{{ $company->name }}</h1>
            <div class=" justify-content-between">
                <a href="{{ route('ゲーム会社編集', ['company' => $company->id]) }}" class="btn btn-sm btn-outline-dark">編集</a>
            </div>
        </div>
    @else
        <h1>{{ $company->name }}</h1>
    @endif


    <div>
        @if ($company->url != null)
        <a href="{{ $company->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($company->wikipedia != null)
        <a href="{{ $company->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>

    <hr>

    <p>
        {{ $company->name }}から発売されているパッケージ
    </p>

    <div class="package-list">
    @foreach ($packages as $package)
        @include('game.common.packageCard', ['soft' => $package, 'toPackage' => true])
    @endforeach
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム会社一覧') }}">ゲーム会社一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection
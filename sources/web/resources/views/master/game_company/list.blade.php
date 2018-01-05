@extends('layouts.master')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-master">
            <li class="breadcrumb-item"><a href="{{ url2('') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/master') }}">マスター</a></li>
            <li class="breadcrumb-item active" aria-current="page">ゲーム会社</li>
        </ol>
    </nav>

    <div>
        <a href="{{ url('master/game_company/create') }}">新規登録</a>
    </div>

    <table class="table table-hover table-clickable-row" data-link="{{ url2('master/game_company/edit/') }}">
        <thead>
        <tr>
            <th>名称</th>
            <th>略称</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($gameCompanies as $gameCompany)
            <tr data-id="{{ $gameCompany->id }}">
                <td>{{ $gameCompany->name }}</td>
                <td>{{ $gameCompany->acronym }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
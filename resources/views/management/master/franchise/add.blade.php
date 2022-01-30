@extends('layouts.management')

@section('title', 'フランチャイズ登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-フランチャイズ') }}">フランチャイズ</a></li>
        <li class="breadcrumb-item active">フランチャイズ登録</li>
    </ol>
    <h1 class="page-header">フランチャイズ登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-フランチャイズ登録処理') }}">
            <div class="panel-body">
                {{ csrf_field() }}

                <table class="table">
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', '') }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', '') }}" required maxlength="100"></td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">登録</button>
            </div>
        </form>
    </div>
@endsection

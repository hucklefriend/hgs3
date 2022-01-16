@extends('layouts.management')

@section('title', 'シリーズ登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-シリーズ') }}">シリーズ</a></li>
        <li class="breadcrumb-item active">シリーズ登録</li>
    </ol>
    <h1 class="page-header">シリーズ登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('管理-マスター-シリーズ登録処理') }}">
                {{ csrf_field() }}

                <table class="table">
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', '') }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', '') }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', '') }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>公式サイトURL</th>
                        <td><input type="url" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', '') }}" required maxlength="300"></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><button type="submit" class="btn btn-default">更新</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection

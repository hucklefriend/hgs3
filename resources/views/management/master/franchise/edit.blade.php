@extends('layouts.management')

@section('title', 'フランチャイズ編集')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-フランチャイズ') }}">フランチャイズ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-フランチャイズ詳細', $franchise) }}">フランチャイズ詳細</a></li>
        <li class="breadcrumb-item active">フランチャイズ編集</li>
    </ol>
    <h1 class="page-header">フランチャイズ編集</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $franchise->name }}</h4>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('管理-マスター-フランチャイズ編集処理', $franchise) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $franchise->id }}</td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $franchise->name) }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', $franchise->acronym) }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', $franchise->phonetic) }}" required maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>公式サイトURL</th>
                        <td><input type="url" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $franchise->url) }}" required maxlength="300"></td>
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

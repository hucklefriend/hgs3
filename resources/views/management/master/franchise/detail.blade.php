@extends('layouts.management')

@section('title', 'フランチャイズ詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-フランチャイズ') . session('search_franchise') }}">フランチャイズ</a></li>
        <li class="breadcrumb-item active">フランチャイズ詳細</li>
    </ol>
    <h1 class="page-header">フランチャイズ詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $model->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-フランチャイズ編集', $model) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <style>
                #franchise-table th {
                    width: 150px;
                }
            </style>
            <table class="table" id="franchise-table">
                <tr>
                    <th>ID</th>
                    <td>{{ $model->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $model->name }}</td>
                </tr>
                <tr>
                    <th>よみがな</th>
                    <td>{{ $model->phonetic }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-フランチャイズ削除', $model) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

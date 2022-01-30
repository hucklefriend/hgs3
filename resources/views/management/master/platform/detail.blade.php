@extends('layouts.management')

@section('title', 'プラットフォーム詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-プラットフォーム') }}">プラットフォーム</a></li>
        <li class="breadcrumb-item active">プラットフォーム詳細</li>
    </ol>
    <h1 class="page-header">プラットフォーム詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $platform->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-プラットフォーム編集', $platform) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $platform->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $platform->name }}</td>
                </tr>
                <tr>
                    <th>略称</th>
                    <td>{{ $platform->acronym }}</td>
                </tr>
                <tr>
                    <th>メーカー</th>
                    <td>{{ $platform?->maker->name ?? '' }}</td>
                </tr>
                <tr>
                    <th>表示順</th>
                    <td>{{ $platform->sort_order }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-プラットフォーム削除', $platform) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

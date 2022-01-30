@extends('layouts.management')

@section('title', 'ハード詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ハード') }}">ハード</a></li>
        <li class="breadcrumb-item active">ハード詳細</li>
    </ol>
    <h1 class="page-header">ハード詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $hard->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-ハード編集', $hard) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $hard->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $hard->name }}</td>
                </tr>
                <tr>
                    <th>略称</th>
                    <td>{{ $hard->acronym }}</td>
                </tr>
                <tr>
                    <th>よみがな</th>
                    <td>{{ $hard->phonetic }}</td>
                </tr>
                <tr>
                    <th>表示順</th>
                    <td>{{ $hard->sort_order }}</td>
                </tr>
                <tr>
                    <th>メーカー</th>
                    <td>{{ $hard->maker?->name }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-ハード削除', $hard) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

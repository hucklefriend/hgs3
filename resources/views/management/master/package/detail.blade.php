@extends('layouts.management')

@section('title', 'パッケージ詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') }}">パッケージ</a></li>
        <li class="breadcrumb-item active">パッケージ詳細</li>
    </ol>
    <h1 class="page-header">パッケージ詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $package->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-パッケージ編集', $package) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $package->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $package->name }}</td>
                </tr>
                <tr>
                    <th>略称</th>
                    <td>{{ $package->acronym }}</td>
                </tr>
                <tr>
                    <th>メーカー</th>
                    <td>{{ $package->maker->name }}</td>
                </tr>
                <tr>
                    <th>発売日</th>
                    <td>{{ $package->release_at }}</td>
                </tr>
                <tr>
                    <th>ソフト</th>
                    <td>
                        <ul>
                            @foreach ($package->getSofts() as $soft)
                                <li>{{ $soft->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-パッケージ削除', $package) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

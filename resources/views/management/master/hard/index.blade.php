@extends('layouts.management')

@section('title', 'ハード')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">Home</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item active">ハード</li>
    </ol>
    <h1 class="page-header">ハード</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">一覧</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-ハード登録') }}" class="btn btn-default"><i class="fas fa-plus"></i></a>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>略称</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach ($hards as $hard)
                    <tr>
                        <td>{{ $hard->id }}</td>
                        <td>{{ $hard->name }}</td>
                        <td>{{ $hard->acronym }}</td>
                        <td class="text-center"><a href="{{ route('管理-マスター-ハード詳細', $hard) }}">詳細</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>{{ $hards->links() }}</div>
        </div>
    </div>

@endsection
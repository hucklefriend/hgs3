@extends('layouts.management')

@section('title', 'フランチャイズ')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">Home</a></li>
        <li class="breadcrumb-item active">フランチャイズ</li>
    </ol>
    <h1 class="page-header">フランチャイズ</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">一覧</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-フランチャイズ登録') }}" class="btn btn-default"><i class="fas fa-plus"></i></a>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach ($franchises as $franchise)
                    <tr>
                        <td>{{ $franchise->id }}</td>
                        <td>{{ $franchise->name }}</td>
                        <td class="text-center"><a href="{{ route('管理-マスター-フランチャイズ詳細', $franchise) }}">詳細</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div>{{ $franchises->links() }}</div>
        </div>
    </div>
    <!-- END panel -->

@endsection

@extends('layouts.management')

@section('title', 'メーカー詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-メーカー') }}">メーカー</a></li>
        <li class="breadcrumb-item active">メーカー詳細</li>
    </ol>
    <h1 class="page-header">メーカー詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $maker->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-メーカー編集', $maker) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $maker->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $maker->name }}</td>
                </tr>
                <tr>
                    <th>略称</th>
                    <td>{{ $maker->acronym }}</td>
                </tr>
                <tr>
                    <th>よみがな</th>
                    <td>{{ $maker->phonetic }}</td>
                </tr>
                <tr>
                    <th>公式サイト</th>
                    <td>@if (empty($maker->url))-@else <a href="{{ $maker->url }}" target="_blank">{{ $maker->url }}</a> @endif</td>
                </tr>
                <tr>
                    <th>アダルトサイトフラグ</th>
                    <td>{{ $maker->is_adult_url }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-メーカー削除', $maker) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

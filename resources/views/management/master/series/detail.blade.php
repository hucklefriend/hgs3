@extends('layouts.management')

@section('title', 'シリーズ詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-シリーズ') }}">シリーズ</a></li>
        <li class="breadcrumb-item active">シリーズ詳細</li>
    </ol>
    <h1 class="page-header">シリーズ詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $series->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-シリーズ編集', $series) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $series->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $series->name }}</td>
                </tr>
                <tr>
                    <th>略称</th>
                    <td>{{ $series->acronym }}</td>
                </tr>
                <tr>
                    <th>よみがな</th>
                    <td>{{ $series->phonetic }}</td>
                </tr>
                <tr>
                    <th>公式サイト</th>
                    <td>@if (empty($series->url))-@else <a href="{{ $series->url }}" target="_blank">{{ $series->url }}</a> @endif</td>
                </tr>
                <tr>
                    <th>アダルトサイトフラグ</th>
                    <td>{{ $series->is_adult_url }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" target="{{ route('管理-マスター-シリーズ削除', $series) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

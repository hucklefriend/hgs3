@extends('layouts.management')

@section('title', 'ソフト詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ソフト') }}">ソフト</a></li>
        <li class="breadcrumb-item active">ソフト詳細</li>
    </ol>
    <h1 class="page-header">ソフト詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $soft->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-ソフト編集', $soft) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $soft->id }}</td>
                </tr>
                <tr>
                    <th>名称</th>
                    <td>{{ $soft->name }}</td>
                </tr>
                <tr>
                    <th>略称</th>
                    <td>{{ $soft->acronym }}</td>
                </tr>
                <tr>
                    <th>よみがな</th>
                    <td>{{ $soft->phonetic }}</td>
                </tr>
                <tr>
                    <th>公式サイト</th>
                    <td>@if (empty($soft->url))-@else <a href="{{ $soft->url }}" target="_blank">{{ $soft->url }}</a> @endif</td>
                </tr>
                <tr>
                    <th>アダルトサイトフラグ</th>
                    <td>{{ $soft->is_adult_url }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" target="{{ route('管理-マスター-ソフト削除', $soft) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

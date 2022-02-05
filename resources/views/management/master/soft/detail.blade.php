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
                    <th>よみがな</th>
                    <td>{{ $soft->phonetic }}</td>
                </tr>
                <tr>
                    <th>よみがな(ソート用)</th>
                    <td>{{ $soft->phonetic2 }}</td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>{{ $soft->genre }}</td>
                </tr>
                <tr>
                    <th>シリーズ</th>
                    <td>{{ $soft?->series->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>フランチャイズ</th>
                    <td>{{ $soft->franchise->name }}</td>
                </tr>
                <tr>
                    <th>原点パッケージ</th>
                    <td>{{ $soft?->originalPackage->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>あらすじ</th>
                    <td>{!! nl2br(e($soft->introduction)) !!}</td>
                </tr>
                <tr>
                    <th>あらすじ引用元</th>
                    <td>{!! $soft->introduction_from !!}</td>
                </tr>
            </table>
        </div>

        @if ($soft->getPackages()->count() == 0)
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-ソフト削除', $soft) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection

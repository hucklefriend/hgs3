@extends('layouts.management')

@section('title', 'ソフト詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ソフト') . session('search_soft') }}">ソフト</a></li>
        <li class="breadcrumb-item active">詳細</li>
    </ol>
    <h1 class="page-header">ソフト詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $model->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-ソフト編集', $model) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
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
                <tr>
                    <th>よみがな(ソート用)</th>
                    <td>{{ $model->phonetic2 }}</td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>{{ $model->genre }}</td>
                </tr>
                <tr>
                    <th>シリーズ</th>
                    <td>{{ $model->series->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>シリーズ内の表示順</th>
                    <td>{{ $model->order_in_series ?? '-' }}</td>
                </tr>
                <tr>
                    <th>フランチャイズ</th>
                    <td>{{ $model->franchise->name }}</td>
                </tr>
                <tr>
                    <th>原点パッケージ</th>
                    <td>{{ $model->originalPackage->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>あらすじ</th>
                    <td>{!! nl2br(e($model->introduction)) !!}</td>
                </tr>
                <tr>
                    <th>あらすじ引用元</th>
                    <td>{!! $model->introduction_from !!}</td>
                </tr>
            </table>
        </div>

        @if ($model->packages()->count() === 0)
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" action="{{ route('管理-マスター-ソフト削除', $model) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection

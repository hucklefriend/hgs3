@extends('layouts.management')

@section('title', 'お知らせ詳細')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-システム-お知らせ') }}">お知らせ</a></li>
        <li class="breadcrumb-item active">お知らせ詳細</li>
    </ol>
    <h1 class="page-header">お知らせ詳細</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $notice->title }}</h4>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-システム-お知らせ編集', $notice) }}" class="btn btn-default"><i class="fas fa-edit"></i></a>
            </div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $notice->id }}</td>
                </tr>
                <tr>
                    <th>タイトル</th>
                    <td>{{ $notice->title }}</td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td>{!! nl2br(e($notice->message)) !!}</td>
                </tr>
                <tr>
                    <th>オープン期間</th>
                    <td>{{ dt_fmt_mng($notice->getOpenAt()) }} ～ {{ dt_fmt_mng($notice->getCloseAt()) }}</td>
                </tr>
                <tr>
                    <th>トップページ表示期間</th>
                    <td>{{ dt_fmt_mng($notice->getTopStartAt()) }} ～ {{ dt_fmt_mng($notice->getTopEndAt()) }}</td>
                </tr>
                <tr>
                    <th>登録日時</th>
                    <td>{{ dt_fmt_mng($notice->getCreatedAt()) }}</td>
                </tr>
                <tr>
                    <th>更新日時</th>
                    <td>{{ dt_fmt_mng($notice->getUpdatedAt()) }}</td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="text-end">
                <form method="POST" target="{{ route('管理-システム-お知らせ削除', $notice) }}" onsubmit="return confirm('削除します');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit"><i class="fas fa-eraser"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

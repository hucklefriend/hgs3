@extends('layouts.management')

@section('title', 'お知らせ')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">Home</a></li>
        <li class="breadcrumb-item active">お知らせ</li>
    </ol>
    <h1 class="page-header">お知らせ</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">一覧</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-システム-お知らせ登録') }}" class="btn btn-default"><i class="fas fa-plus"></i></a>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>タイトル</th>
                    <th>表示期間</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach ($notices as $notice)
                    <tr>
                        <td>{{ $notice->id }}</td>
                        <td>{{ $notice->title }}</td>
                        <td>{{ dt_fmt_mng($notice->getOpenAt(), '-') }} ～ {{ dt_fmt_mng($notice->getCloseAt(), '-') }}</td>
                        <td class="text-center"><a href="{{ route('管理-システム-お知らせ詳細', $notice) }}">詳細</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            <div>{{ $notices->links() }}</div>
        </div>
    </div>
    <!-- END panel -->

@endsection

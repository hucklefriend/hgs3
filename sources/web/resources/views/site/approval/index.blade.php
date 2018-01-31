@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('管理メニュー') }}">&lt;</a>
@endsection

@section('content')

    <h1>承認待ちサイト一覧</h1>

    <table class="table table-responsive">
        <tr>
            <th>サイト名</th>
            <th>登録日時</th>
        </tr>
        @foreach ($sites as $site)
            <tr>
                <td>
                    <a href="{{ route('サイト判定', ['site' => $site->id]) }}">{{ $site->name }}</a>
                </td>
                <td>
                    {{ $site->created_at }}
                </td>
            </tr>
        @endforeach
    </table>

    {{ $sites->render() }}

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('管理メニュー') }}">管理メニュー</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト承認</li>
        </ol>
    </nav>
@endsection
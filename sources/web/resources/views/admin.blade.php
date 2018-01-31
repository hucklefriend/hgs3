@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('マイページ') }}">&lt;</a>
@endsection

@section('content')
    @if ($approvalWaitNum > 0)
        <div class="alert alert-danger" role="alert">
            <a href="{{ route('承認待ちサイト一覧') }}" class="alert-link">承認待ちのサイトが{{ $approvalWaitNum }}件あります！</a>
        </div>
    @endif

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">管理メニュー</li>
        </ol>
    </nav>
@endsection

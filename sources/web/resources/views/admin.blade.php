@extends('layouts.app')

@section('global_back_link'){{ route('マイページ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>管理</h1>
        </header>
    @if ($approvalWaitNum > 0)
        <div class="alert alert-danger" role="alert">
            <a href="{{ route('承認待ちサイト一覧') }}" class="alert-link">承認待ちのサイトが{{ $approvalWaitNum }}件あります！</a>
        </div>
    @endif
    </div>

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

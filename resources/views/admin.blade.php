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
        @if ($reviewUrlWaitNum > 0)
            <div class="alert alert-danger" role="alert">
                <a href="{{ route('レビューURL判定') }}" class="alert-link">URL承認待ちのレビューが{{ $reviewUrlWaitNum }}件あります！</a>
            </div>
        @endif
    </div>

@endsection

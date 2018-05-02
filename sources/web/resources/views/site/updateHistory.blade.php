@extends('layouts.app')

@section('title')サイト更新履歴@endsection
@section('global_back_link'){{ route('サイト詳細', ['site' => $site->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト更新履歴</h1>
        </header>

    @foreach($updateHistories as $updateHistory)
        <div class="card">
            <div class="card-body">
                <div><small>{{ $updateHistory->site_updated_at }}</small></div>
                <div>{!! nl2br(e($updateHistory->detail)); !!}</div>
            </div>
        </div>
        @if (!$loop->last) <hr> @endif
    @endforeach

    @include('common.pager', ['pager' => $updateHistories])

    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト詳細', ['site' => $site->id]) }}">サイト詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">更新履歴</li>
        </ol>
    </nav>
@endsection
@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト詳細', ['site' => $site->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>サイト更新履歴</h1>

    @foreach($updateHistories as $updateHistory)
        <div>{{ $updateHistory->site_updated_at }}</div>
        <div>{!! nl2br(e($updateHistory->detail)); !!}</div>
        @if (!$loop->last) <hr> @endif
    @endforeach

    @include('common.pager', ['pager' => $updateHistories])

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
@extends('layouts.app')

@section('content')
    <h1>システム更新内容</h1>

    <div class="card">
        <div class="card-header">
            {{ $updateHistory->title }}
        </div>
        <div class="card-body">
            <p>{{ $updateHistory->update_at }}</p>
            <p class="card-text">
                {!! nl2br(e($updateHistory->detail)) !!}
            </p>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('システム更新履歴') }}">システム更新履歴</a></li>
            <li class="breadcrumb-item active" aria-current="page">システム更新内容</li>
        </ol>
    </nav>
@endsection

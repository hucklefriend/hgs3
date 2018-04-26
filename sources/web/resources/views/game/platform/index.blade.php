@extends('layouts.app')

@section('title')プラットフォーム@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プラットフォーム一覧</h1>
        </header>
        <ul class="list-group no-border">
            @foreach ($platforms as $p)
                <li class="list-group-item"><a href="{{ route('プラットフォーム詳細', ['platform' => $p->id]) }}">{{ $p->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">プラットフォーム一覧</li>
        </ol>
    </nav>
@endsection

@extends('layouts.app')

@section('title')シリーズ@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>シリーズ一覧</h1>
        </header>
        <ul class="list-group no-border">
            @foreach ($series as $s)
                <li class="list-group-item"><a href="{{ route('シリーズ詳細', ['series' => $s->id]) }}">{{ $s->name }}</a></li>
            @endforeach
        </ul>
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">シリーズ一覧</li>
        </ol>
    </nav>
@endsection

@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>シリーズ一覧</h1>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('シリーズ登録') }}" class="btn btn-sm btn-outline-info">新規登録</a>
    </div>
    @endif

    <ul class="list-group">
    @foreach ($series as $s)
        <li class="list-group-item"><a href="{{ route('シリーズ詳細', ['series' => $s->id]) }}">{{ $s->name }}</a></li>
    @endforeach
    </ul>

    @include('common.pager', ['pager' => $series])

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">シリーズ一覧</li>
        </ol>
    </nav>
@endsection

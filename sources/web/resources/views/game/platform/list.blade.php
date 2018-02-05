@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h4>プラットフォーム一覧</h4>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('プラットフォーム登録') }}" class="btn btn-sm btn-outline-info">新規登録</a>
    </div>
    @endif

    <ul class="list-group">
        @foreach ($platforms as $p)
            <li class="list-group-item"><a href="{{ route('プラットフォーム詳細', ['platform' => $p->id]) }}">{{ $p->name }}</a></li>
        @endforeach
    </ul>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">プラットフォーム一覧</li>
        </ol>
    </nav>
@endsection

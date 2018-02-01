@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('システム更新履歴') }}"><i class="fas fa-angle-left"></i></a>
@endsection

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
            @if (is_admin())
            <a class="btn btn-sm btn-outline-info" href="{{ route('システム更新履歴更新', ['updateHistory' => $updateHistory->id]) }}" role="button">編集</a>
            @endif
        </div>
    </div>

    @if (is_admin())
    <div class="btn-area">
        <form action="{{ route('システム更新履歴削除', ['updateHistory' => $updateHistory->id]) }}" onsubmit="return confirm('削除してよろしいですか？');" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn btn-sm btn-danger" type="submit">削除</button>
        </form>
    </div>
    @endif
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('システム更新履歴') }}">システム更新履歴</a></li>
            <li class="breadcrumb-item active" aria-current="page">システム更新内容</li>
        </ol>
    </nav>
@endsection

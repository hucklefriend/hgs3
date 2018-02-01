@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('お知らせ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>お知らせ</h1>

    <div class="card">
        <div class="card-header">
            {{ $notice->title }}
        </div>
        <div class="card-body">
            <p>{{ $notice->open_at }}</p>
            <p class="card-text">
                {!! nl2br(e($notice->message)) !!}
            </p>
            @if (is_admin())
            <a class="btn btn-sm btn-outline-info" href="{{ route('お知らせ編集', ['notice' => $notice->id]) }}" role="button">編集</a>
            @endif
        </div>
    </div>

    @if (is_admin())
    <div class="btn-area">
        <form action="{{ route('お知らせ削除', ['notice' => $notice->id]) }}" onsubmit="return confirm('削除してよろしいですか？');" method="POST">
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
            <li class="breadcrumb-item"><a href="{{ route('お知らせ') }}">お知らせ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ内容</li>
        </ol>
    </nav>
@endsection

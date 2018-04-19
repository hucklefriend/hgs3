@extends('layouts.app')

@section('title')お知らせ一覧@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')

    @if (is_admin())
        <div class="d-flex justify-content-between">
            <h1>お知らせ一覧</h1>
            <div>
                <a href="{{ route('お知らせ登録') }}" class="btn btn-sm btn-outline-dark">新規登録</a>
            </div>
        </div>
        <div>
            <a href="{{ route('未来のお知らせ') }}">未来のお知らせ</a> |
            <a href="{{ route('過去のお知らせ') }}">過去のお知らせ</a>
        </div>
    @else
        <h1>お知らせ</h1>
    @endif

    @foreach ($notices as $notice)
        <div class="my-3">
            <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}" class="btn btn-outline-dark border-0 d-block">
                <div class="d-flex justify-content-between">
                    <div class="force-break mr-2 text-left">
                        <div><small>{{ $notice->open_at_str }}</small></div>
                        <div class="font-weight-bold">{{ $notice->title }}</div>
                        <div>{!! str_limit(strip_tags($notice->message), 100)  !!}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

    @include('common.pager', ['pager' => $notices])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ</li>
        </ol>
    </nav>
@endsection
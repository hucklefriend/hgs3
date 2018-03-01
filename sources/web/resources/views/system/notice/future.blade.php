@extends('layouts.app')

@section('title')未来のお知らせ一覧 | @endsection

@section('global_back_link')
    <a href="{{ route('お知らせ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>未来のお知らせ</h1>

    @foreach ($notices as $notice)
        <div class="my-3">
            <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}" class="btn btn-outline-dark border-0 d-block">
                <div class="d-flex justify-content-between">
                    <div class="force-break mr-2 text-left">
                        <div><small>{{ $notice->open_at_str }}</small></div>
                        <div class="font-weight-bold">{{ $notice->title }}</div>
                        <div>{{ str_limit($notice->message, 100) }}</div>
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
            <li class="breadcrumb-item"><a href="{{ route('お知らせ') }}">お知らせ</a></li>
            <li class="breadcrumb-item active" aria-current="page">未来</li>
        </ol>
    </nav>
@endsection
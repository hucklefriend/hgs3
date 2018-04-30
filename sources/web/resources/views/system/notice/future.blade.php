@extends('layouts.app')

@section('title')未来のお知らせ一覧@endsection
@section('global_back_link'){{ route('お知らせ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>お知らせ一覧</h1>
        </header>

        @if (is_admin())
            <div>
                <a href="{{ route('お知らせ登録') }}">新規登録</a> |
                <a href="{{ route('未来のお知らせ') }}">未来のお知らせ</a> |
                <a href="{{ route('過去のお知らせ') }}">過去のお知らせ</a>
            </div>
        @endif

        @foreach ($notices as $notice)
            <div class="my-3 card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="force-break mr-2 text-left">
                            <h4 class="card-title">{{ $notice->title }}</h4>
                            <div>{!! str_limit(strip_tags($notice->message), 100)  !!}</div>
                            <div><small>{{ $notice->open_at_str }}</small></div>
                        </div>
                        <div class="align-self-center">
                            <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}" class="btn btn-outline-dark border-0 d-block">
                                <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @include('common.pager', ['pager' => $notices])
    </div>
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
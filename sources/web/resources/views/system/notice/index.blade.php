@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    @if (is_admin())
        <div class="d-flex justify-content-between">
            <h1>お知らせ</h1>
            <div>
                <a href="{{ route('お知らせ登録') }}" class="btn btn-sm btn-outline-dark">新規登録</a>
            </div>
        </div>
    @else
        <h1>お知らせ</h1>
    @endif

    @foreach ($notices as $notice)
        <div class="my-3">
            <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}" class="btn btn-outline-secondary border-0 d-block">
                <div class="d-flex justify-content-between">
                    <div class="force-break mr-2 text-left">
                        <div><small>{{ $notice->open_at }}</small></div>
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
            <li class="breadcrumb-item active" aria-current="page">お知らせ</li>
        </ol>
    </nav>
@endsection
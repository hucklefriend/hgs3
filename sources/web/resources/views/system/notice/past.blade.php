@extends('layouts.app')

@section('title')終了したお知らせ@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('お知らせ') }}@endsection

@section('content')

    <h1>終了したお知らせ</h1>

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

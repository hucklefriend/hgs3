@extends('layouts.app')

@section('title', 'お知らせ一覧')
@section('global_back_link', \Hgs3\Http\GlobalBack::clearAndRoute('トップ'))

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>お知らせ一覧</h1>
        </header>

        @foreach ($notices as $notice)
            <div class="my-3 card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="force-break mr-2 text-left">
                            <h4 class="card-title">{{ $notice->title }}</h4>
                            <div>{!! strip_tags($notice->message)  !!}</div>
                            <div><small>{{ format_date($notice->getOpenAt()) }}</small></div>
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

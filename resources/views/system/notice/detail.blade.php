@extends('layouts.app')

@section('title', 'お知らせ')
@section('global_back_link', \Hgs3\Http\GlobalBack::clearAndRoute('お知らせ'))

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>お知らせ</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $notice->title }}</h4>
                <h6 class="card-subtitle">{{ format_date(strtotime($notice->open_at)) }}</h6>

                <p class="force-break">{!! nl2br($notice->message) !!}</p>
            </div>
        </div>
    </div>
@endsection

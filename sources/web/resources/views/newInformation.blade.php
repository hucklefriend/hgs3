@extends('layouts.app')

@section('title')新着情報@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>新着情報</h1>
        </header>

        <div class="listview listview--bordered">

        @foreach ($newInfo as $nf)
            <div class="listview__item">
                <div class="listview__content">
                    <span class="listview__heading">
                        {!! $nf['text'] !!}
                    </span>
                    <p>{{ format_date($nf->time) }}</p>
                </div>
            </div>

        @endforeach

        @include('common.pager', ['pager' => $newInfo])
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">新着情報</li>
        </ol>
    </nav>
@endsection
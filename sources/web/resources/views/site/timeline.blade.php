@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ route('サイトトップ') }}@endsection

@section('content')
    <h1>タイムライン</h1>

    <div class="d-flex flex-row">
        <div class="d-none d-sm-block">
            <div class="site-side-menu">
                @include('site.common.sideMenu', ['active' => 'タイムライン'])
            </div>
        </div>
        <div style="width: 100%;">
            @foreach ($timelines as $timeline)
                <p class="mb-4">
                    {{ date('Y-m-d H:i', $timeline->time) }}<br>
                    {!! nl2br($timeline->text) !!}
                </p>
            @endforeach
        </div>
    </div>
@endsection

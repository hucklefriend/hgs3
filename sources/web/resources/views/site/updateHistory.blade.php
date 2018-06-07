@extends('layouts.app')

@section('title')サイト更新履歴@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteUpdateHistory($site) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト更新履歴</h1>
        </header>

    @foreach($updateHistories as $updateHistory)
        <div class="card">
            <div class="card-body">
                <div><small>{{ $updateHistory->site_updated_at }}</small></div>
                <div>{!! nl2br(e($updateHistory->detail)); !!}</div>
            </div>
        </div>
        @if (!$loop->last) <hr> @endif
    @endforeach

    @include('common.pager', ['pager' => $updateHistories])

    </div>

@endsection

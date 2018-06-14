@extends('layouts.app')

@section('title')サイト更新履歴@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteUpdateHistory($site) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $site->name }}</h1>
            <p>サイトの更新履歴</p>
        </header>

        <div class="card">
            <div class="card-body">
                @foreach($updateHistories as $updateHistory)
                <p class="mb-1"><small>{{ format_date2(strtotime($updateHistory->site_updated_at)) }}</small></p>
                <p class="mb-0">{!! nl2br(e($updateHistory->detail)); !!}</p>
                @if (!$loop->last) <hr> @endif
                @endforeach
            </div>
        </div>
        @include('common.pager', ['pager' => $updateHistories])
    </div>

@endsection

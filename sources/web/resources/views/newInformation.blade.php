@extends('layouts.app')

@section('title')新着情報 | @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>新着情報</h1>

    @foreach ($newInfo as $nf)
        <div class="mb-5">
            {{ format_date($nf->open_at_ts) }}<br>
            @if ($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_GAME)
                <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>が追加されました。
            @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_SITE)
                新着サイトです！<a href="{{ route('サイト詳細', ['site' => $nf->site_id]) }}">「{{ hv($siteHash, $nf->site_id) }}」</a>
            @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_REVIEW)
                <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>の新しいレビューが投稿されました！
            @endif
        </div>
    @endforeach

    @include('common.pager', ['pager' => $newInfo])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">新着情報</li>
        </ol>
    </nav>
@endsection
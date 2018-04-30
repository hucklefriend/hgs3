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

                <div class="listview__content text-truncate text-truncate">
                    <span class="listview__heading">
                        @if ($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_GAME)
                            <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>が追加されました。
                        @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_SITE)
                            新着サイトです！<a href="{{ route('サイト詳細', ['site' => $nf->site_id]) }}">「{{ hv($siteHash, $nf->site_id) }}」</a>
                        @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_REVIEW)
                            <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>の新しいレビューが投稿されました！
                        @endif
                    </span>
                    <p>{{ format_date($nf->open_at_ts) }}</p>
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
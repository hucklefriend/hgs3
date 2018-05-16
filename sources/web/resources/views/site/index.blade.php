@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト</h1>
        </header>
@if (!empty($timelines))

        <div class="ticker-title hidden-sm-up">
            <span>新着情報！</span>
        </div>
        <div class="ticker">
            <ul>
    @foreach ($timelines as $tl)
                <li>{!! $tl['text'] !!}</li>
    @endforeach
            </ul>

            <div class="ticker-title-inline hidden-xs-down">新着情報！</div>
        </div>

        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">新着サイト</h4>
                        <div class="card-text">
                            @if ($newArrivals->count() == 0)
                                <p>新着サイトはありません。</p>
                            @else
                                <div class="swiper-container" id="new_arrivals_list">
                                    <div class="swiper-wrapper">

                                @foreach ($newArrivals as $s)
                                        <div class="swiper-slide">
                                             @include('site.common.swipe', ['s' => $s, 'u' => $webmasters[$s->user_id] ?? null, 'noUser' => !isset($webmasters[$s->user_id])])
                                        </div>
                                @endforeach

                                    </div>

                                    <!-- Add Pagination -->
                                    <div class="text-center mt-3">
                                        <button class="btn btn-light btn--icon" id="new_arrivals_prev"><i class="fas fa-caret-left"></i></button>
                                        <span id="new_arrivals_pagination" class="mx-5"></span>
                                        <button class="btn btn-light btn--icon" id="new_arrivals_next"><i class="fas fa-caret-right"></i></button>
                                    </div>
                                </div>

                                <div class="text-right mt-5">
                                    <a href="{{ route('新着サイト一覧') }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">更新サイト</h4>
                        <div class="card-text">
                            @if ($updateArrivals->count() == 0)
                                <p>更新サイトはありません。</p>
                            @else
                                <div class="swiper-container" id="updates_list">
                                    <div class="swiper-wrapper">
                                @foreach ($updateArrivals as $s)
                                        <div class="swiper-slide">
                                            @include('site.common.swipe', ['s' => $s, 'u' => $webmasters[$s->user_id] ?? null, 'noUser' => !isset($webmasters[$s->user_id])])
                                        </div>
                                @endforeach
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-light btn--icon" id="updates_prev"><i class="fas fa-caret-left"></i></button>
                                        <span id="updates_pagination" class="mx-5"></span>
                                        <button class="btn btn-light btn--icon" id="updates_next"><i class="fas fa-caret-right"></i></button>
                                    </div>
                                </div>

                                <div class="text-right mt-5">
                                    <a href="{{ route('更新サイト一覧') }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--
    <div class="card card-hgn">
        <div class="card-body">
            <h4 class="card-title">ゲームからサイトを探す</h4>
            <div class="card-text">
                <div>
                    ゲームから探す
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-body">
            <h4 class="card-title">メインコンテンツからサイトを探す</h4>
            <div class="card-text">
                <div class="contacts row">
                    @foreach (\Hgs3\Constants\Site\MainContents::getData() as $mcId => $mcName)
                        <div class="col-xl-2 col-lg-3 col-sm-4 col-12">
                            <div class="contacts__item">
                                <div>
                                    <a href="{{ route('ゲーム会社詳細', ['company' => $mcId]) }}">{{ $mcName }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
--}}
    <style>

        .ticker {
            position: relative;
            padding: 0 0 0 0;
            background-color: rgba(0,0,0,.2);
            border-radius: 3px;
            margin-bottom: 20px;
        }


        .ticker-title {
            background-color: rgba(0,0,0,.4);
            padding: 10px;
            color: #FFF;
            display: inline-block;
        }

        .ticker-title-inline {
            content: "新着情報！";
            display: inline-block;
            background-color: rgba(0,0,0,.2);
            padding: 10px;
            color: #FFF;
            position: absolute;
            top: 0;
            left: 0;
        }
        .ticker:after {
            content: '';
            display: block;
            top: 0;
            left: 80px;
            height: 80px;
        }
        .ticker ul {
            padding-left: 20px !important;
        }
        .ticker ul li {
            list-style: none;
            padding: 10px 0;
            overflow: hidden;
            white-space: nowrap;
        }

        @media (min-width:576px) {
            .ticker {
                padding: 0 0 0 80px;
            }
        }

    </style>

    <script src="{{ url('js/jquery.easy-ticker.min.js') }}"></script>
    <script>
        let swiper = null;
        let swiper2 = null;

        $(function(){
            $('.ticker').easyTicker({
                visible: 1,
                interval: 4000
            });

            swiper = new Swiper('#new_arrivals_list', {
                pagination: {
                    el: '#new_arrivals_pagination',
                    type: 'fraction',
                },
                navigation: {
                    nextEl: '#new_arrivals_next',
                    prevEl: '#new_arrivals_prev',
                },
            });
            swiper2 = new Swiper('#updates_list', {
                pagination: {
                    el: '#updates_pagination',
                    type: 'fraction',
                },
                navigation: {
                    nextEl: '#updates_next',
                    prevEl: '#updates_prev',
                },
            });

            setSiteSwipeHeight();
            $(window).resize(function() {
                setSiteSwipeHeight();
            });
        });


        function setSiteSwipeHeight()
        {
            let maxHeight = 0;
            $('#new_arrivals_list .site-swipe').css('height', 'auto');

            $('#new_arrivals_list .site-swipe').each(function (){
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });

            $('#new_arrivals_list .site-swipe').height(maxHeight + 'px');

            maxHeight = 0;
            $('#updates_list .site-swipe').css('height', 'auto');

            $('#updates_list .site-swipe').each(function (){
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });

            $('#updates_list .site-swipe').height(maxHeight + 'px');
        }
    </script>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト</li>
        </ol>
    </nav>
@endsection